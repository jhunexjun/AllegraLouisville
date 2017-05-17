<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class salesController extends Controller
{
    public function getSalesData(Request $request) {
        if (!$request->has('salesStartDate') || !$request->has('salesEndDate'))
            return response()->json(['error' => 1, 'message' => 'tart and end date.']);

        $salesStartDate = $request->input('salesStartDate');
        $salesEndDate = $request->input('salesEndDate');

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://uat-3pa.dmotorworks.com/pip-extract/fisales-closed/extract', [
            'auth' => [config('app.dms_username'), config('app.dms_password')],
            'form_params' => [
                'qparamStartDate' => $salesStartDate,
                'qparamEndDate' => $salesEndDate,
                'dealerId' => config('app.dms_dealerId'),
                'queryId' => 'FISC_DateRange',
            ]
        ]);

        $xml = simplexml_load_string($res->getBody()->getContents());
        return response()->json($xml);
    }
}
