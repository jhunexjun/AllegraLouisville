<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class SalesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getSalesData(Request $request) {
        if (!$request->has('salesStartDate') || !$request->has('salesEndDate') || !$request->has('dealerID'))
            return view('sales', ['result' => json_encode([])]);

        $salesStartDate = $request->input('salesStartDate');
        $salesEndDate = $request->input('salesEndDate');

        $dealers = \App\Dealer::all();

        $client = new \GuzzleHttp\Client();

        try {
            $res = $client->request('POST', 'https://uat-3pa.dmotorworks.com/pip-extract/fisales-closed/extract', [
                'auth' => [config('app.dms_username'), config('app.dms_password')],
                'form_params' => [
                    'qparamStartDate' => $salesStartDate,
                    'qparamEndDate' => $salesEndDate,
                    'dealerId' => $request->input('dealerID'),
                    'queryId' => 'FISC_DateRange',
                ]
            ]);
        } catch (RequestException $e) {
            $response = '';

            if ($e->hasResponse())
                $response = Psr7\str($e->getResponse());

            $errorMessage = "Request: " .Psr7\str($e->getRequest()) . ' Response: ' . $response;
            error_log($errorMessage);
            
            return view('sales', ['result' => json_encode([]), 'dealerIDs' => $dealers]);
        }

        $xml = simplexml_load_string($res->getBody()->getContents());
        $json = json_encode($xml);
        /*$object = json_decode($json);

        foreach ($object->FISalesClosed as $key => $recordObj)
            $object->FISalesClosed[$key]->DealerId = $request->input('dealerID');

        $json = json_encode($object);*/

        return view('sales', ['result' => $json, 'dealerIDs' => $dealers]);
    }
}
