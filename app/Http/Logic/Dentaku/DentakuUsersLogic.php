<?php

namespace App\Http\Logic\Dentaku;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;
use Illuminate\Support\Facades\Validator;

class DentakuUsersLogic extends \App\Http\Logic\BaseLogic
{
    public function usersShow(){
        \Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $dao = new \App\Http\Model\usersDAO;   //DBクラスを取得
        $data = $dao->show();

    	$resultDTO->setResults($data);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        return $resultDTO;
    }
}