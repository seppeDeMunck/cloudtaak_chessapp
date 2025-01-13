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
            'location' => 'http://localhost:5001/soap',
            'uri'      => 'http://schemas.xmlsoap.org/soap/envelope/',
            'trace'    => 1,
            'exceptions' => true,
        ]);
    }

    public function showPage3(Request $request)
    {
        $player = $request->input('player');
        $playerId = $request->input('player_id');
        $games = [];
        $feedback = '';
        $response = null;

        if ($player) {
            try {
                // Use the SOAP client to get games for a specific player
                $response = $this->soapClient->__soapCall('getPlayerGames', [['player' => $player]]);
                Log::info('SOAP Response: ' . print_r($response, true));

                // Debugging: Inspect the response
                // dd($response);

                if (isset($response->Game)) {
                    foreach ($response->Game as $item) {
                        $games[] = [
                            'id'         => (string)$item->id,
                            'black'      => (string)$item->black,
                            'white'      => (string)$item->white,
                            'winner'     => (string)$item->winner,
                            'moves'      => (string)$item->moves,
                            'created_at' => (string)$item->created_at,
                        ];
                    }
                } else if (is_array($response) && isset($response[0]->Game)) {
                    foreach ($response[0]->Game as $item) {
                        $games[] = [
                            'id'         => (string)$item->id,
                            'black'      => (string)$item->black,
                            'white'      => (string)$item->white,
                            'winner'     => (string)$item->winner,
                            'moves'      => (string)$item->moves,
                            'created_at' => (string)$item->created_at,
                        ];
                    }
                }

                // Debugging: Inspect the games array
                // dd($games);

            } catch (\SoapFault $e) {
                dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
            }
        }

        if ($playerId) {
            try {
                // Use the SOAP client to get feedback for a specific player ID
                $feedback = $this->soapClient->__soapCall('getPlayerFeedback', [['player_id' => $playerId]]);
            } catch (\SoapFault $e) {
                dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
            }
        }

        return view('page3', compact('games', 'player', 'feedback', 'playerId', 'response'));
    }
}