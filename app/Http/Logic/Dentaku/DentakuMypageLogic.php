<?php

namespace App\Http\Logic\Dentaku;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;
use Illuminate\Support\Facades\Validator;
use Session;

class DentakuMypageLogic extends \App\Http\Logic\BaseLogic
{
    public function mypageShow()
    {
        \Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $dao = new \App\Http\Model\mypageDAO;   //DBクラスを取得
        $data =  $dao->show();
        $resultDTO->setInputs($data["myData"]);
    	$resultDTO->setResults($data["myAnswers"]);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        return $resultDTO;
    }

    public function editValidate(Request $request){
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

        $inputs = $request->all();
        if(Session::get("user_id") != $request->userID || $request->userID == null)
        {
            $rules = [
                "userID" => "required|min:6|max:20|regex:/^[0-9a-zA-Z_\.\-]+$/|unique:users,user_id",
                "name" => "required|max:15",
                "comment" => "max:50",
            ];
        } else {
            $rules = [
                "userID" => "required|min:6|max:20|regex:/^[0-9a-zA-Z_\.\-]+$/|exists:users,user_id",
                "name" => "required|max:15",
                "comment" => "max:50",
            ];
        }
        $validation = \Validator::make($inputs, $rules);
        if($validation->fails()){
            $errors = json_decode($validation->errors(), true);
            $resultDTO->setErrors($errors);
            // 失敗時にステータスをFAILUREにする
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }
        return $resultDTO;
    }

    public function mypageEdit(Request $request){
        \Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $dao = new \App\Http\Model\mypageDAO;   //DBクラスを取得
        $data = $dao->edit($request);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        return $resultDTO;
    }
}