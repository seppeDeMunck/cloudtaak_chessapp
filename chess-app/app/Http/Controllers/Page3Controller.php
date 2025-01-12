<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class Page3Controller extends Controller
{
    private $soapClient;

    public function __construct()
    {
        // Initialize the SOAP client
        $this->soapClient = new \SoapClient(null, [
            'location' => 'http://soap-adapter:5001/soap',
            'uri' => 'http://schemas.xmlsoap.org/soap/envelope/',
            'trace' => 1,
        ]);
    }

    public function showPage3(Request $request)
    {
        $player = $request->input('player');
        $games = [];

        if ($player) {
            $soapRequest = $this->buildSoapRequest('GetGamesByPlayer', ['player' => $player]);

            try {
                $response = $this->soapClient->__doRequest($soapRequest, 'http://soap-adapter:5001/soap', '', 1);
                $games = $this->parseSoapResponse($response, 'GetGamesByPlayerResponse');
            } catch (Exception $e) {
                return redirect()->back()->withErrors(['Exception: ' . $e->getMessage()]);
            }
        }

        return view('page3', compact('games', 'player'));
    }

    public function getGameFeedback(Request $request)
    {
        $request->validate([
            'game_id' => 'required|integer',
        ]);

        $soapRequest = $this->buildSoapRequest('GetGameFeedback', [
            'game_id' => $request->input('game_id'),
        ]);

        try {
            $response = $this->soapClient->__doRequest($soapRequest, 'http://soap-adapter:5001/soap', '', 1);
            $feedback = $this->parseSoapResponse($response, 'GetGameFeedbackResponse');

            return redirect()->back()->with('feedback', $feedback);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['Exception: ' . $e->getMessage()]);
        }
    }

    private function buildSoapRequest($action, $params)
    {
        $xml = new \SimpleXMLElement('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"/>');
        $body = $xml->addChild('soap:Body');
        $actionElement = $body->addChild($action);

        foreach ($params as $key => $value) {
            $actionElement->addChild($key, $value);
        }

        return $xml->asXML();
    }

    private function parseSoapResponse($response, $action)
    {
        $xml = new \SimpleXMLElement($response);
        $body = $xml->children('http://schemas.xmlsoap.org/soap/envelope/')->Body;
        $actionResponse = $body->children()->{$action};

        $result = [];
        foreach ($actionResponse->children() as $child) {
            $result[] = (array) $child;
        }

        return $result;
    }
}