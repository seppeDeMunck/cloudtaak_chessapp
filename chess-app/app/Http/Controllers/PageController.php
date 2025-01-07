<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showPage1()
    {
        $games = Game::all();
        return view('page1', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'black' => 'required|string|max:255',
            'white' => 'required|string|max:255',
            'winner' => 'required|string|max:255',
            'moves' => 'required|string',
        ]);

        Game::create([
            'black' => $request->black,
            'white' => $request->white,
            'winner' => $request->winner,
            'moves' => $request->moves,
        ]);

        return redirect()->back()->with('success', 'Game added successfully!');
    }
}