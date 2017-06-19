<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://uat-3pa.dmotorworks.com/pip-extract/fisales-closed/extract', [
            'auth' => [config('app.dms_username'), config('app.dms_password')],
            'form_params' => [
                'qparamStartDate' => $salesStartDate,
                'qparamEndDate' => $salesEndDate,
                'dealerId' => $request->input('dealerID'),
                'queryId' => 'FISC_DateRange',
            ]
        ]);

        $xml = simplexml_load_string($res->getBody()->getContents());
        $json = json_encode($xml);

        $dealers = \App\Dealer::all();

        return view('sales', ['result' => $json, 'dealerIDs' => $dealers]);
    }
}
