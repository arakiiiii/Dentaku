<?php

namespace App\Http\Logic\Dentaku;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class DentakuLogic extends \App\Http\Logic\BaseLogic
{
     /**
     * エラーチェック
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validate(Request $request){
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

        \Log::info(__METHOD__);
        $inputs = $request->all();
        $rules = [
            "param.*" => "required_with_all:array,kigouArray",
            "param" => "required|array",
        ];
        $validation = \Validator::make($inputs, $rules);
        if($validation->fails()){
            $errors = json_decode($validation->errors(), true);
            $resultDTO->setErrors($errors);
            // 失敗時にステータスをFAILUREにする
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
    	    return $resultDTO;
        }

        $inputs = $request->param;
   		$rules = [
            "array" => "bail|required|array|max:5",
            "kigouArray"=>"required|array|max:10",
            "array.*"=>"numeric|max:9999999|min:-9999999",
            "kigouArray.*" => ["regex:/^(\+|\-|\*|\/)$/"],
        ];
        //attributeについては /resources/lang/ja/validation.php のattributesに定義する必要がある
        $validation = \Validator::make($inputs, $rules);

    	// 入力値の保存
    	$resultDTO->setInputs($this->getRequestParameter($request));
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        if($validation->fails()){
            $errors = json_decode($validation->errors(), true);
            $resultDTO->setErrors($errors);
            // 失敗時にステータスをFAILUREにする
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }

    	return $resultDTO;
    }


    /**
     * DBから履歴を受け取る
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function showHistoryLogic()
    {
        \Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $dao = new \App\Http\Model\AnswerDAO;   //DBクラスを取得
        $histories = $dao->showHistoryDAO();

    	$resultDTO->setResults($histories);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        return $resultDTO;
    }

    /**
     * 計算処理を実行
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function saveDataLogic(Request $request)
    {
        \Log::info(__METHOD__);

        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        $resultDTO->setInputs($this->getRequestParameter($request));

        $kigouArray = $request->param["kigouArray"];
        $array = $request->param['array'];

        $kigou ="";
        $before = 0;
        $num = 0;
        $siki = "";

        for($i=0; $i < count($array); $i++){
            $num = round($array[$i], 5); //文字列を数字に直す

            if($before != ""){
                switch($kigouArray[$e]){
                    case "+":
                    $before += $array[$i];
                    break;

                    case "-":
                    $before -= $array[$i];
                    break;

                    case "*":
                    $before *= $array[$i];
                    break;

                    case "/":
                    $before /= $array[$i];
                    break;
                }

                $siki .= " ";

                if($kigouArray[$e]=="*"){
                    $siki .= "×";
                }else if($kigouArray[$e]=="/"){
                    $siki .= "÷";
                }else{
                    $siki .= "$kigouArray[$e]";
                }

                $siki .= " ";

            } else {
                $before = $array[$i]; //一回目の数字をbeforeに入れる
            }
            $e = $i;

            $siki .= "$array[$i]";
        }

        //$beforeをDAOに渡す
        $siki .= " "."="." ";
        $siki .= "$before";
        $param = [
            "siki" => $siki,
            "result" => $before,
        ];
        $dao = new \App\Http\Model\AnswerDAO;
        $data = $dao->saveDataDAO($param);

        $resultDTO->setResults($data);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        return $resultDTO;
    }

    /**
     * 履歴削除メソッド
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function deleteDataLogic()
    {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

        $dao = new \App\Http\Model\AnswerDAO;
        $dao->deleteDataDAO();

        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        return $resultDTO;
    }
}