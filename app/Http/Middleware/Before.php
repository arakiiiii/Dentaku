<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Before
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
        \Log::info(__METHOD__);
        if(Session::get("id") == null){
            return redirect()->action("Dentaku\DentakuLoginController@login");
        }
        $user = DB::table("users")->where("id",Session::get("id"))->first();
        if($user == null){
            return redirect()->action("Dentaku\DentakuLoginController@login");
        }
        return $next($request);
    }
}
