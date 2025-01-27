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

        // Retrieve players input from the request
        $playersInput = $request->input('players');
        if (!$playersInput) {
            Log::warning('No players input received');
            return view('page2', [
                'rounds' => [],
                'players' => null,
                'error' => 'No players input provided.'
            ]);
        }

        Log::info('Connecting to MQTT broker');

        // Initialize MQTT client with a unique client ID
        $clientId = 'laravel-client_' . uniqid();
        $mqtt = new MqttClient('localhost', 1883, $clientId);

        // Configure connection settings
        $connectionSettings = (new ConnectionSettings)
            ->setUsername(null) // Set if authentication is required
            ->setPassword(null) // Set if authentication is required
            ->setKeepAliveInterval(60)
            ->setLastWillTopic(null)
            ->setLastWillMessage(null)
            ->setLastWillQualityOfService(0);

        try {
            // Connect to the MQTT broker with a clean session
            $mqtt->connect($connectionSettings, true);
            Log::info('Connected to MQTT broker');
        } catch (\Exception $e) {
            Log::error('Failed to connect to MQTT broker: ' . $e->getMessage());
            return view('page2', [
                'rounds' => [],
                'players' => $playersInput,
                'error' => 'Failed to connect to MQTT broker.'
            ]);
        }

        $rounds = [];
        $roundsReceived = false;

        // Subscribe to the 'competition/rounds' topic
        try {
            $mqtt->subscribe('competition/rounds', function (string $topic, string $message) use (&$rounds, &$roundsReceived, $mqtt) {
                Log::info('Received MQTT message on topic: ' . $topic, ['message' => $message]);

                // Decode the JSON message
                $data = json_decode($message, true);

                // Check for JSON decoding errors
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON decode error: ' . json_last_error_msg());
                    return;
                }

                // Verify that 'rounds' key exists
                if (isset($data['rounds'])) {
                    $rounds = $data['rounds'];
                    $roundsReceived = true;
                    Log::info('Rounds received from competition planner', ['rounds' => $rounds]);

                    // Interrupt the MQTT loop to exit immediately
                    $mqtt->interrupt();
                } else {
                    Log::warning('Rounds data missing in MQTT message', ['message' => $message]);
                }
            }, 1); // QoS 1 for guaranteed delivery

            Log::info('Subscribed to competition/rounds topic');
        } catch (\Exception $e) {
            Log::error('Failed to subscribe to competition/rounds: ' . $e->getMessage());
            $mqtt->disconnect();
            return view('page2', [
                'rounds' => [],
                'players' => $playersInput,
                'error' => 'Failed to subscribe to competition/rounds.'
            ]);
        }

        // Prepare and publish the players data to 'competition/players' topic
        Log::info('Preparing players data for MQTT', ['playersInput' => $playersInput]);
        $players = array_map('trim', explode(',', $playersInput));
        $payload = json_encode(['players' => $players]);

        try {
            $mqtt->publish('competition/players', $payload, 1);
            Log::info('Players published to MQTT', ['payload' => $payload]);
        } catch (\Exception $e) {
            Log::error('Failed to publish players to MQTT: ' . $e->getMessage());
            $mqtt->disconnect();
            return view('page2', [
                'rounds' => [],
                'players' => $playersInput,
                'error' => 'Failed to publish players to MQTT.'
            ]);
        }

        // Start the MQTT loop to listen for incoming messages
        Log::info('Starting MQTT loop to listen for rounds');
        $startTime = time();
        $maxTimeout = 30; // Maximum of 30 seconds

        while ((time() - $startTime) < $maxTimeout) {
            try {
                // Processes MQTT events; allows the loop to sleep if there's nothing to process
                $mqtt->loop(true, 1); // $allowSleep = true, $timeout = 1 second
            } catch (\Exception $e) {
                Log::error('MQTT loop error: ' . $e->getMessage());
                break; // Exit the loop on exception
            }

            Log::info('Looping... roundsReceived = ' . ($roundsReceived ? 'true' : 'false'));

            if ($roundsReceived) {
                Log::info('Rounds successfully received within timeout.');
                break; // Exit the loop immediately
            }

            usleep(100000); // Sleep for 0.1 seconds to prevent CPU exhaustion
        }

        // Disconnect from the MQTT broker
        try {
            $mqtt->disconnect();
            Log::info('Disconnected from MQTT broker');
        } catch (\Exception $e) {
            Log::error('Failed to disconnect from MQTT broker: ' . $e->getMessage());
        }

        // Render the view with the received rounds and players
        return view('page2', [
            'rounds' => $rounds,
            'players' => $playersInput,
            'error' => !$roundsReceived ? 'Failed to receive rounds in time.' : null
        ]);
    }
}