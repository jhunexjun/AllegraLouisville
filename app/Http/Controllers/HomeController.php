<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Dealer;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealers = App\Dealer::all();
        $dealerIDs = [];
        foreach ($dealers as $dealer)
            $dealerIDs[] = $dealer->dealerId;

        return view('home', ['dealerIDs' => $dealerIDs]);
    }
}
