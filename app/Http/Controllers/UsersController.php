<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use JavaScript;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$user = \Auth::user();
    	$users = DB::table('users')->select('id', 'name', 'email')->where("id", '!=', $user->id)->get();

    	JavaScript::put(['users' => $users]);
    	
        return view('showUsers');
    }
}
