<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class AnswerDAO extends Model
{
    //DB関連のやつを書いていく
    public function showHistoryDAO(){
        //AnswerDBからデータを受け取る
            $histories = DB::table('answers')->where("user_id",\Session::get("id"))->orderBy("id","desc")->get();
        return $histories;
    }

    public function saveDataDAO($request){
        //履歴のために追加
        $param = [
            'answer' => $request["siki"],
            "user_id" => \Session::get("id"),
            "result"=> $request["result"],
        ];
        DB::table('answers')->insert($param);

        $param = [
            $data = DB::table("answers")->where('answer',$request["siki"])->first(),
            $histories = DB::table('answers')->where("user_id",\Session::get("id"))->orderBy("id","desc")->get(),
        ];
        return $param;
    }

    public function deleteDataDAO(){
        $delete = DB::table('answers')->where('user_id',\Session::get("id"))->get("answer");
        for($i=0; $i<count($delete); $i++){
            DB::table("delAnswers")->insert([
                "delAnswer" => $delete[$i]->answer,
                "user_id" => Session::get("id"),
                ]);
            }
        $delete = DB::table('answers')->where('user_id',\Session::get("id"))->delete();
        return;
    }
}
