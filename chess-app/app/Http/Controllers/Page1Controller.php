<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Page1Controller extends Controller
{
    private $soapClient;

    public function __construct()
    {
        $this->soapClient = new \SoapClient(null, [
            'location' => 'http://localhost:8080/soap-server.php',
            'uri' => 'http://localhost/soap-server.php',
            'trace' => 1,
            'exceptions' => true,
        ]);
    }

    public function showPage1(Request $request)
    {
        $player = $request->input('player');
        try {
            // Use the SOAP client to get games for a specific player
            $games = $this->soapClient->__soapCall('getPlayerGames', [$player]);
            return view('page1', compact('games', 'player'));
        } catch (\SoapFault $e) {
            dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'black' => 'required|string|max:255',
            'white' => 'required|string|max:255',
            'winner' => 'required|string|max:255',
            'moves' => 'required|string',
        ]);

        try {
            // Use the SOAP client to add a game
            $this->soapClient->__soapCall('addGame', [
                $request->black,
                $request->white,
                $request->winner,
                $request->moves
            ]);

            return redirect()->back()->with('success', 'Game added successfully!');
        } catch (\SoapFault $e) {
            dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
        }
    }
}