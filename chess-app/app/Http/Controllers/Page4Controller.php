<?php
// filepath: /c:/Users/dmsep/ChessApp/chess-app/app/Http/Controllers/Page4Controller.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Page4Controller extends Controller
{
    public function showPage4(Request $request)
    {
        $player = $request->input('player');
        $response = Http::post('http://localhost:5000/get-games', [
            'player' => $player,
        ]);
        $games = $response->json();
        return view('page4', compact('games', 'player'));
    }

    public function calculateWinChance(Request $request)
    {
        $player1 = $request->input('player1');
        $player2 = $request->input('player2');

        // Call the Python REST API
        $response = Http::post('http://localhost:5000/calculate-win-chance', [
            'player1' => $player1,
            'player2' => $player2,
        ]);

        $winChance = $response->json();

        return view('page4', compact('winChance', 'player1', 'player2'));
    }
}