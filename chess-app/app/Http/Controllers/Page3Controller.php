<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Page3Controller extends Controller
{
    private $soapClient;

    public function __construct()
    {
        $this->soapClient = new \SoapClient(null, [
            'location'   => 'http://localhost:5001/soap',
            'uri'        => 'http://schemas.xmlsoap.org/soap/envelope/',
            'trace'      => 1,
            'exceptions' => true,
        ]);
    }

    public function showPage3(Request $request)
    {
        Log::info('Page3Controller called');

        $player = $request->input('player');
        $playerId = $request->input('player_id');
        $games = [];
        $feedback = '';

        if ($player) {
            try {
                $response = $this->soapClient->__soapCall('getPlayerGames', [['player' => $player]]);
                Log::info('Raw SOAP Response: ' . print_r($response, true));

                // Debugging: Check the structure before conversion
                if (is_object($response)) {
                    Log::info('Response is an object with properties: ' . implode(', ', array_keys(get_object_vars($response))));
                } elseif (is_array($response)) {
                    Log::info('Response is an array with keys: ' . implode(', ', array_keys($response)));
                }

                // Attempt conversion
                $games = $this->convertGames($response);
                Log::info('Converted Games Data: ' . print_r($games, true));

            } catch (\SoapFault $e) {
                Log::error('SOAP Error: ' . $e->getMessage());
                dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
            }
        }

        if ($playerId) {
            try {
                $response = $this->soapClient->__soapCall('getMoveSuggestion', [['game_id' => $playerId]]);
                Log::info('Raw SOAP Response for Move Suggestion: ' . print_r($response, true));

                if (isset($response->suggestion)) {
                    $feedback = (string)$response->suggestion;
                }

            } catch (\SoapFault $e) {
                Log::error('SOAP Error (Move Suggestion): ' . $e->getMessage());
                dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
            }
        }

        return view('page3', compact('games', 'player', 'feedback', 'playerId'));
    }

    /**
     * Converts SOAP response to a properly formatted associative array.
     */
    private function convertGames($response)
    {
        // Log full response structure before trying to convert
        Log::info('Full Response from SOAP:', (array) $response);

        if (is_array($response) && isset($response['Game'])) {
            Log::info('Found response["Game"], processing...');
            
            // Extract games array
            $gamesArray = $response['Game'];
            
            // Convert games and return them
            return $this->convertGameArray($gamesArray);
        }

        Log::warning('Game data still not found! Check the response structure.');
        return [];
    }

    /**
     * Converts an array of stdClass game objects to an associative array.
     */
    private function convertGameArray($gameArray)
    {
        $convertedGames = [];

        foreach ($gameArray as $game) {
            $converted = (array) $game;
            Log::info('Converted Game Object: ' . print_r($converted, true));
            $convertedGames[] = $converted;
        }

        return $convertedGames;
    }
}
