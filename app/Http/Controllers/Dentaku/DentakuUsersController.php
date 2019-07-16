<?php

namespace App\Http\Controllers\Dentaku;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class DentakuUsersController extends Controller
{
    public function usersShow(Request $request){
        \Log::info(__METHOD__);
        $logic = new \App\Http\Logic\Dentaku\DentakuUsersLogic;
        $data = $logic->usersShow();

        return view("dentaku.users",$data->getForView($request));
    }
}