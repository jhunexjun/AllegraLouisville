<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use JavaScript;

class DealerController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index() {
        // $dealers = \App\Dealer::all();
    	$this->getDealers();
    	
        return view('dealers');
    }

    private function getDealers() {
        $dealers = DB::table('dealers')->select('id', 'dealerId')->get();
        JavaScript::put(['dealers' => $dealers]);
        // return $dealers;
    }

    public function addDealer(Request $request) {
        $error = ['error' => ['errorCode' => 1, 'message' => 'No dealer id.']];

        if (!$request->has('dealerId')) {
            $this->getDealers();
            return view('dealers', $error);
        }

        DB::table('dealers')->insert([
                'dealerId' => $request->input('dealerId'),
                'created_at' => date('Y-m-d H:i:s')
            ]);

        return view('dealers', $error = []);
    }
}
