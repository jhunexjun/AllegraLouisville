<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestJsonController extends Controller
{
    public function getTestJson() {
    	$records[] = ["Airi", "Satou", "Accountant", "Tokyo", "28th Nov 08", "$162,700"];
    	$records[] = ["Angelica", "Ramos", "Chief Executive Officer (CEO)", "London", "9th Oct 09", "$1,200,000"];
    	$records[] = ["Ashton", "Cox", "Junior Technical Author", "San Francisco", "12th Jan 09", "$86,000"];
    	$records[] = ["Bradley", "Greer", "Software Engineer", "London", "13th Oct 12", "$132,000"];
    	$records[] = ["Brenden", "Wagner", "Software Engineer", "San Francisco", "7th Jun 11", "$206,850"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	$records[] = ["Brielle", "Williamson", "Integration Specialist", "New York", "2nd Dec 12", "$372,000"];
    	
    	
    	return response()->json($records);
    }
}
