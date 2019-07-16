<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class usersDAO extends Model
{
    public function show(){
        $data = DB::table("users")->whereNotIn("id",[Session::get("id")])->orderBy("id","desc")->paginate(8);
        for($i=0; $i<count($data); $i++){
            $answer = DB::table("answers")->where("user_id",$data[$i]->id)->orderBy("id","desc")->get();
            $data[$i]->answer = $answer;
        }
        return $data;
    }
    // public function show(){
    //     $data = DB::table("users")->whereNotIn("id",[Session::get("id")])->orderBy("id","desc")->simplePaginate(3);
    //     $data = json_decode(json_encode($data), true);
    //     $data = $data["data"];
    //     for($i=0; $i<count($data); $i++){
    //         $answer = DB::table("answers")->where("user_id",$data[$i]["id"])->get();
    //         $answer = json_decode(json_encode($answer), true);
    //         $data[$i][] = $answer;
    //     }
    //     return $data;
    // }
}