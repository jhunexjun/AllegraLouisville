<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function getServiceData(Request $request) {
        if (!$request->has('serviceStartDate') || !$request->has('serviceEndDate') || !$request->has('dealerID'))
            return view('service', ['result' => json_encode([])]);

        $serviceStartDate = $request->input('serviceStartDate');
        $serviceEndDate = $request->input('serviceEndDate');

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://uat-3pa.dmotorworks.com/pip-extract/servicesalesclosedext/extract', [
            'auth' => [config('app.dms_username'), config('app.dms_password')],
            'form_params' => [
                'qparamStartDate' => $serviceStartDate,
                'qparamEndDate' => $serviceEndDate,
                'dealerId' => $request->input('dealerID'),
                'queryId' => 'SSC_DateRange_H',
            ]
        ]);

        $xml = simplexml_load_string($res->getBody()->getContents());
        $json = json_encode($xml);

        $dealers = \App\Dealer::all();

        return view('service', ['result' => $json, 'dealerIDs' => $dealers]);
    }
}
