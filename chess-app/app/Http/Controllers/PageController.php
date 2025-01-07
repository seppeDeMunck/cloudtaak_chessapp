<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class PageController extends Controller
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

    public function showPage1()
    {
        try {
            $games = Game::all();
            return view('page1', compact('games'));
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
            // Add game via SOAP service
            $this->soapClient->addGame($request->black, $request->white, $request->winner, $request->moves);

            // Do not add the game again in Laravel
            // Game::create([
            //     'black' => $request->black,
            //     'white' => $request->white,
            //     'winner' => $request->winner,
            //     'moves' => $request->moves,
            //     'created_at' => Carbon::now(),
            // ]);

            return redirect()->back()->with('success', 'Game added successfully!');
        } catch (\SoapFault $e) {
            dd($e->getMessage(), $this->soapClient->__getLastRequest(), $this->soapClient->__getLastResponse());
        }
    }
}