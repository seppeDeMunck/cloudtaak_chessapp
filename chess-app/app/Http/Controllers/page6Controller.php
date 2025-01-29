<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Page6Controller extends Controller
{
    public function showAnalyzeForm()
    {
        Log::info('showAnalyzeForm method called');
        return view('page6');
    }

    public function analyzePosition(Request $request)
    {
        Log::info('analyzePosition method called');

        $fen = $request->input('fen');
        Log::info('FEN: ' . $fen);

        $response = Http::post('http://localhost:9000/analyze', [
            'fen' => $fen,
        ]);

        Log::info('Stockfish Response Status: ' . $response->status());
        Log::info('Stockfish Response Body: ' . $response->body());

        if ($response->successful()) {
            $responseJson = $response->json();
            Log::info('Stockfish Response JSON: ' . json_encode($responseJson));
            return $responseJson;
        } else {
            Log::error('Stockfish Error: ' . $response->body());
            return response()->json(['error' => 'An error occurred while analyzing the position'], 500);
        }
    }
}