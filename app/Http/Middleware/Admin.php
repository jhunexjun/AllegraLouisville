<?php

/* This will check if the current user has administration privilege. */

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\DB;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentUser = \Auth::user();
        $users = DB::table('users')->select('admin')->where('id', $currentUser->id)->first();

        if ($users->admin)
            return $next($request);
        else
            return redirect('home');
    }
}
