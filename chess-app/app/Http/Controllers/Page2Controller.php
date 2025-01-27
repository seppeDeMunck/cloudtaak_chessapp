<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use Illuminate\Support\Facades\Log;

class Page2Controller extends Controller
{
    public function showPage2(Request $request)
    {
        Log::info('showPage2 called');

        $playersInput = $request->input('players');
        if (!$playersInput) {
            Log::warning('No players input received');
            return view('page2', ['rounds' => [], 'players' => null]);
        }

        Log::info('Connecting to MQTT broker');

        // Initialize MQTT client with unique client ID
        $mqtt = new MqttClient('localhost', 1883, 'laravel-client_' . uniqid());
        $connectionSettings = (new ConnectionSettings)
            ->setUsername(null)
            ->setPassword(null)
            ->setKeepAliveInterval(60)
            ->setLastWillTopic(null)
            ->setLastWillMessage(null)
            ->setLastWillQualityOfService(0);

        try {
            $mqtt->connect($connectionSettings);
            Log::info('Connected to MQTT broker');
        } catch (\Exception $e) {
            Log::error('Failed to connect to MQTT broker: ' . $e->getMessage());
            return view('page2', ['rounds' => [], 'players' => $playersInput, 'error' => 'Failed to connect to MQTT broker.']);
        }

        $rounds = [];
        $roundsReceived = false;

        // Subscribe to the 'competition/rounds' topic
        $mqtt->subscribe('competition/rounds', function (string $topic, string $message) use (&$rounds, &$roundsReceived) {
            Log::info('Received MQTT message on topic: ' . $topic, ['message' => $message]);

            $data = json_decode($message, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('JSON decode error: ' . json_last_error_msg());
                return;
            }

            if (isset($data['rounds'])) {
                $rounds = $data['rounds'];
                $roundsReceived = true;
                Log::info('Rounds received from competition planner', ['rounds' => $rounds]);
            } else {
                Log::warning('Rounds data missing in MQTT message', ['message' => $message]);
            }
        }, 1); // QoS 1 for guaranteed delivery

        // Publish the players to the 'competition/players' topic
        Log::info('Publishing players to MQTT', ['players' => $playersInput]);
        $mqtt->publish('competition/players', json_encode([
            'players' => array_map('trim', explode(',', $playersInput))
        ]), 1);
        Log::info('Players published to MQTT');

        // Start the MQTT loop to listen for incoming messages
        Log::info('Starting MQTT loop');
        $startTime = time();
        $maxTimeout = 30; // Maximum of 30 seconds

        while ((time() - $startTime) < $maxTimeout) {
            try {
                $mqtt->loop(true, 1); // $allowSleep = true, $timeout = 1 second
            } catch (\Exception $e) {
                Log::error('MQTT loop error: ' . $e->getMessage());
                break;
            }

            Log::info('Looping... roundsReceived = ' . ($roundsReceived ? 'true' : 'false'));

            if ($roundsReceived) {
                Log::info('Rounds successfully received. Exiting loop.');
                break; // Exit the loop immediately
            }

            usleep(100000); // Sleep for 0.1 seconds to prevent CPU exhaustion
        }

        if ($roundsReceived) {
            Log::info('Rounds successfully received.');
        } else {
            Log::warning('Did not receive rounds within the timeout period.');
        }

        // Disconnect from the MQTT broker
        $mqtt->disconnect();
        Log::info('Disconnected from MQTT broker');

        // Render the view with the received rounds
        return view('page2', ['rounds' => $rounds, 'players' => $playersInput]);
    }
}