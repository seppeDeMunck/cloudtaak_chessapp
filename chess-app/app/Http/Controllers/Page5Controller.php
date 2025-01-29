<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Page5Controller extends Controller
{
    public function showPage5()
    {
        Log::info('showPage5 method called');
        return view('page5');
    }

    public function getWikiData(Request $request)
    {
        Log::info('getWikiData method called');

        $query = $request->input('query');
        Log::info('GraphQL Query: ' . $query);

        $payload = [
            'query' => $query,
        ];

        Log::info('GraphQL Payload: ' . json_encode($payload));

        $response = Http::post('http://localhost:4000/query', $payload);

        Log::info('GraphQL Response Status: ' . $response->status());
        Log::info('GraphQL Response Body: ' . $response->body());

        if ($response->successful()) {
            $responseJson = $response->json();
            $responseString = json_encode($responseJson);
            Log::info('GraphQL Response JSON: ' . json_encode($responseJson));
            Log::info('GraphQL Response String: ' . $responseString);
            return $responseJson;
        } else {
            Log::error('GraphQL Error: ' . $response->body());
            return response()->json(['error' => 'An error occurred while fetching the data'], 500);
        }
    }
}