<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class loginDAO extends Model{

    public function signup($data){
        $params = [
            "name" => $data->name,
            "user_id" => $data->userID,
            "password" => bcrypt($data->input('password')),
            "comment" => "",
        ];
        DB::table("users")->insert($params);
        return;
    }

    public function signIn($data){
        $user = DB::table("users")->where('user_id',$data->userID)->first();
        if($user != null){
            if(password_verify($data->password,$user->password)){
                $data->session()->put('id',$user->id);
                $data->session()->put('name',$user->name);
                $data->session()->put('user_id',$user->user_id);
            } else {
                $errors = "パスワードまたはユーザーIDが違います";
                return $errors;
            }
        }
        return;
    }

}