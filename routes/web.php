<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(["middleware" => "beforeLogin","prefix"=>""], function(){

    Route::get('home','Dentaku\DentakuController@home');
    Route::post('/sendData','Dentaku\DentakuController@sendData');
    Route::post('/deleteData','Dentaku\DentakuController@deleteData');

    Route::get('/users',"Dentaku\DentakuUsersController@usersShow");
    Route::get('/mypage',"Dentaku\DentakuMypageController@mypageShow");
    Route::post('/edit',"Dentaku\DentakuMypageController@mypageEdit");
});
Route::get('/login','Dentaku\DentakuLoginController@login');
Route::post('/signIn',"Dentaku\DentakuLoginController@signIn");

Route::get('/register','Dentaku\DentakuLoginController@register');
Route::post('/signUp',"Dentaku\DentakuLoginController@signUp");

Route::get('/logout',"Dentaku\DentakuLoginController@logout");

Route::fallback(function() {
    return "404";
});