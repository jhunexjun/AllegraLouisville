<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class ServiceController extends Controller
{
    private $url = '';

    public function __construct() {
        $this->middleware('auth');

        if (\App::environment(['local', 'staging']))
            $this->url = 'https://uat-3pa.dmotorworks.com/pip-extract/servicesalesclosedext/extract';
        else
            $this->url = 'https://3pa.dmotorworks.com/pip-extract/servicesalesclosedext/extract';
    }

    public function getServiceData(Request $request) {
        if (!$request->has('serviceStartDate') || !$request->has('serviceEndDate') || !$request->has('dealerID'))
            return view('service', ['result' => json_encode([])]);

        $serviceStartDate = $request->input('serviceStartDate');
        $serviceEndDate = $request->input('serviceEndDate');

        $dealers = \App\Dealer::all();

        $client = new \GuzzleHttp\Client();
        
        try {
            $res = $client->request('POST', $this->url, [
                'auth' => [config('app.dms_username'), config('app.dms_password')],
                'form_params' => [
                    'qparamStartDate' => $serviceStartDate,
                    'qparamEndDate' => $serviceEndDate,
                    'dealerId' => $request->input('dealerID'),
                    'queryId' => 'SSC_DateRange_H',
                ]
            ]);
        } catch (RequestException $e) {
            $response = '';

            if ($e->hasResponse())
                $response = Psr7\str($e->getResponse());

            $errorMessage = "Request: " .Psr7\str($e->getRequest()) . ' Response: ' . $response;
            error_log($errorMessage);

            return view('service', ['result' => json_encode([]), 'dealerIDs' => $dealers]);
        }

        $xml = simplexml_load_string($res->getBody()->getContents());
        $json = json_encode($xml);

        return view('service', ['result' => $json, 'dealerIDs' => $dealers]);
    }
}
