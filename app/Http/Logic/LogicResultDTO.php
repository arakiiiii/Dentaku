<?php

namespace App\Http\Logic;
use Illuminate\Http\Request;

/**
 * ロジックの結果情報用DTO
 * @author Administrator
 *
 */
class LogicResultDTO {

    const SUCCESS = 1;
    const FAILURE = -1;

    private $status;
    // 入力情報や初期表示のArrayリスト
    private $inputs;
    // 検索結果などのArrayリスト
    private $results;
    // エラー情報の格納
    private $errors; //基本Arrayを格納する

    public function __construct() {
        $this->status = self::SUCCESS;
    }

    public function getStatus() {
    	return $this->status;
    }

    public function setStatus($status) {
    	$this->status = $status;
    }

    public function getInputs() {
    	return $this->inputs;
    }
    public function setInputs($inputs) {
    	$this->inputs = $inputs;
    }

    public function getResults() {
    	return $this->results;
    }

    public function setResults($results) {
    	$this->results = $results;
    }

    public function getErrors() {
    	return $this->errors;
    }

    public function setErrors($errors) {
    	$this->errors = $errors;
    }

    /**
     * View用にArray化したデータを生成する
     */
    public function getForView(Request $request) {
    	return [
    			"status" => $this->status,
    			"errors" => $this->errors,
    			"results" => $this->results,
    			"inputs" => $this->inputs,
    			"SUCCESS" => self::SUCCESS,
    			"FAILURE" => self::FAILURE,
    			"pageShowUuid" => $request->getSession()->get($request->getUri() . "::pageShowUuid"),
    	];
    }
}
