<?php

namespace App\Http\Controllers\Dentaku;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class DentakuMypageController extends Controller
{
    public function mypageShow(Request $request)
    {
        \Log::info(__METHOD__);
        $logic = new \App\Http\Logic\Dentaku\DentakuMypageLogic;
        $data = $logic->mypageShow();
        return view('dentaku.mypage',$data->getForView($request));
    }

    public function mypageEdit(Request $request)
    {
        \Log::info(__METHOD__);
        $logic = new \App\Http\Logic\Dentaku\DentakuMypageLogic;
        $results = $logic->editValidate($request);
		if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
            $logic->mypageEdit($request);
            return;
		} else {
            // エラーの場合、エラー内容をVIEW用の配列を詰めて終了
            return view("dentaku.error",$results->getForView($request));
        }
    }
}