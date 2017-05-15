<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestJsonController extends Controller
{
    public function getTestJson() {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', 'https://uat-3pa.dmotorworks.com/pip-extract/fisales-closed/extract', [
            'auth' => ['advantageconcepts', '8XnIEitP78vE'],
            'form_params' => [
                'qparamStartDate' => '01/01/2012',
                'qparamEndDate' => '01/03/2012',
                'dealerId' => '3PAACONCEPTSDEV1',
                'queryId' => 'FISC_DateRange',
            ]
        ]);

        $xml = simplexml_load_string($res->getBody()->getContents());
        // $json = json_encode($xml);
        // $array = json_decode($json,TRUE);
        return response()->json($xml);
    }

    public function getTestServiceJson() {
        $records[] = ["csjer", "zaml", "745  e c", "Ohio", "2nd Feb 24", "$57,000"];
        $records[] = ["qavgju", "ecott", "tyvdr55hv", "California", "2nd Oct 57", "$324,470"];
        $records[] = ["uii", "qcpsyg", "wqmlaa", "grtret", "2nd Sep 77", "$858,778"];
        $records[] = ["vcashj", "bhksxxas", "vzmwor", "drtert", "2nd Aug 31", "$758,251"];
        $records[] = ["kopp", "uiondds", "juexclop", "Manila", "2nd Apr 89", "$475,893"];
        $records[] = ["bxcvm", "vrftyutu", "qakop", "Cebu", "2nd Mar 73", "$110,788"];
        $records[] = ["Airi", "Satou", "Accountant", "Tokyo", "28th Nov 08", "$162,700"];
        $records[] = ["Angelica", "Ramos", "Chief Executive Officer (CEO)", "London", "9th Oct 09", "$1,200,000"];
        $records[] = ["Ashton", "Cox", "Junior Technical Author", "San Francisco", "12th Jan 09", "$86,000"];
        $records[] = ["Bradley", "Greer", "Software Engineer", "London", "13th Oct 12", "$132,000"];
        $records[] = ["Brenden", "Wagner", "Software Engineer", "San Francisco", "7th Jun 11", "$206,850"];
        $records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
        $records[] = ["khjkh", "excgyj", "yuiycvver ", "New Jersey", "2nd Jan 14", "$11,000"];
        
        
        return response()->json($records);
    }
}
