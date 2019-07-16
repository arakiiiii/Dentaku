<?php

namespace App\Http\Logic\Dentaku;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;
use Illuminate\Support\Facades\Validator;

class DentakuLoginLogic extends \App\Http\Logic\BaseLogic
{
    public function signInValidate(Request $request){
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $inputs = $request->all();
        $rules = [
            "userID" => "required|min:6|max:20|regex:/\A[0-9a-zA-Z_\.\-]+\z/|exists:users,user_id",
            "password" => "required|min:6|max:20|regex:/\A[0-9a-zA-Z_\.\-]+\z/",
        ];
        $validation = \Validator::make($inputs, $rules);

        if($validation->fails()){
            $errors = json_decode($validation->errors(), true);
            $resultDTO->setErrors($errors);
            // 失敗時にステータスをFAILUREにする
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }
        return $resultDTO;
    }

    public function signIn(Request $request)
    {
        \Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $dao = new \App\Http\Model\loginDAO;   //DBクラスを取得
        $histories = $dao->signIn($request);
        if($histories != null){
            $inputs = $request->all();
            $rules = [
                "password" => "exists:users,password"
            ];
            $validation = \Validator::make($inputs, $rules);
            $errors = json_decode($validation->errors(), true);
            $resultDTO->setErrors($errors);
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        } else {
            $resultDTO->setResults($histories);
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        }

        return $resultDTO;
    }

    public function signUpValidate(Request $request)
    {
         \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

        $inputs = $request->all();
        $rules = [
            "userID" => "required|unique:users,user_id|min:6|max:20|regex:/^[0-9a-zA-Z_\.\-]+$/",
            "name" => "required|max:15",
            "password" => "required|min:6|max:20|regex:/^[0-9a-zA-Z_\.\-]+$/",
        ];
        $validation = \Validator::make($inputs, $rules);

        if($validation->fails()){
            $errors = json_decode($validation->errors(), true);
            $resultDTO->setErrors($errors);
            // 失敗時にステータスをFAILUREにする
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }
        return $resultDTO;
    }

    public function signup(Request $request)
    {
        \Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $dao = new \App\Http\Model\loginDAO;   //DBクラスを取得
        $dao->signup($request);

        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        return $resultDTO;
    }
}