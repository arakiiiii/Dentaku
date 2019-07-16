<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;

class mypageDAO extends Model
{
    public function show(){
        $params = [
            "myData" => DB::table("users")->where("id",Session::get('id'))->first(),
            "myAnswers" => DB::table("answers")->where("user_id",Session::get('id'))->orderBy("id","desc")->paginate(5),
        ];
        return $params;
    }

    public function edit($request){
        DB::table("users")->where("id",Session::get("id"))->update([
            "user_id" => $request->userID,
            "name" => $request->name,
            "comment" => $request->comment,
        ]);
        $id = Session::get("id");

        Session::put('id',$id);
        Session::put('name',$request->name);
        Session::put('user_id'.$request->userID);

        return;
    }
}