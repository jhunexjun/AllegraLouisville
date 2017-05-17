<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class serviceController extends Controller
{
    public function getServiceData(Request $request) {
        if (!$request->has('serviceStartDate') || !$request->has('serviceEndDate'))
            return response()->json(['error' => 1, 'message' => 'tart and end date.']);

        $serviceStartDate = $request->input('serviceStartDate');
        $serviceEndDate = $request->input('serviceEndDate');

        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://uat-3pa.dmotorworks.com/pip-extract/servicesalesclosedext/extract', [
            'auth' => [config('app.dms_username'), config('app.dms_password')],
            'form_params' => [
                'qparamStartDate' => $serviceStartDate,
                'qparamEndDate' => $serviceEndDate,
                'dealerId' => config('app.dms_dealerId'),
                'queryId' => 'SSC_DateRange_H',
            ]
        ]);

        $xml = simplexml_load_string($res->getBody()->getContents());
        return response()->json($xml);
    }
}
