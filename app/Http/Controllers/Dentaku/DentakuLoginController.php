<?php

namespace App\Http\Controllers\Dentaku;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DentakuLoginController extends Controller
{
    public function login(Request $request){
        return view('dentaku.login',$request);
    }
    public function signIn(Request $request){

        \Log::info(__METHOD__);
        $logic = new \App\Http\Logic\Dentaku\DentakuLoginLogic;
        $results = $logic->signInValidate($request);
		if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
            // エラー出ない場合はログインする
            $results = $logic->signIn($request);
            // 認証に成功した
            if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
                return redirect()->action("Dentaku\DentakuController@home");
            }
        }
        // エラーの場合、エラー内容をVIEW用の配列を詰めて終了
        return redirect()->action("Dentaku\DentakuLoginController@login",$results->getForView($request));
    }

    public function register(Request $request){
        return view("dentaku.register",$request);
    }

    public function signUp(Request $request)
    {
        \Log::info(__METHOD__);
        $logic = new \App\Http\Logic\Dentaku\DentakuLoginLogic;
        $results = $logic->signUpValidate($request);
        if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
            // エラー出ない場合は新規登録する
            $logic->signup($request);

            // 認証に成功した
            $logic->signIn($request);
            return redirect()->action("Dentaku\DentakuController@home");
		} else {
            // エラーの場合、エラー内容をVIEW用の配列を詰めて終了
            return redirect()->action("Dentaku\DentakuLoginController@register",$results->getForView($request));
        }
    }

    public function logout(){
        \Log::info(__METHOD__);
        session()->flush();
        return redirect()->action("Dentaku\DentakuLoginController@login");
    }
}
