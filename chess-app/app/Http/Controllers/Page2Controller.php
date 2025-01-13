<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Page2Controller extends Controller
{
    public function showPage2(Request $request)
    {
        $players = $request->input('players');
        $rounds = [];

        if ($players) {
            try {
                // Call the competition service to get rounds
                $response = Http::post('http://localhost:3000/competition', [
                    'players' => explode(',', $players)
                ]);

                if ($response->successful()) {
                    $rounds = $response->json()['rounds'];
                } else {
                    return redirect()->back()->withErrors(['error' => 'Failed to get rounds from competition service.']);
                }
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }

        return view('page2', compact('rounds', 'players'));
    }
}