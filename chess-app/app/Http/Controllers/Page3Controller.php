<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $games = [];

        if ($player) {
            try {
                // Modify the SOAP request to match the expected structure
                $response = $this->soapClient->__soapCall('getPlayerGames', [
                    ['player' => $player]
                ]);

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
                }

                // Debugging: Inspect the games array
                // dd($games);

            } catch (\SoapFault $e) {
                dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
            }
        }

        return view('page3', compact('games', 'player'));
    }

    public function getGameFeedback(Request $request)
    {
        $request->validate([
            'game_id' => 'required|integer',
        ]);

        $feedback = null;

        try {
            $response = $this->soapClient->__soapCall('getGameFeedback', [
                ['game_id' => $request->input('game_id')]
            ]);
            if (isset($response->Body->GetGameFeedbackResponse->feedback)) {
                $feedback = (string)$response->Body->GetGameFeedbackResponse->feedback;
            }
        } catch (\SoapFault $e) {
            dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
        }

        return view('page3', compact('feedback'));
    }
}