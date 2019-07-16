<?php

namespace Tests\Feature\dentaku;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

use Session;

class mypageFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

//編集の正常値
    public function testMypageEdit1()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "userID"=>"aiueo1234",
                "name"=>"aiueo",
                "comment"=>"上田です"
            ]
        );

        $this->assertDatabaseHas("users",
            [
                "user_id"=>"aiueo1234",
                "name"=>"aiueo",
                "comment"=>"上田です",
            ]
            );
    }

//編集の異常値
    public function testMypageEdit2()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "userID"=>"asfasfasfdsafsfaffasfasfasfasfdasfdafasfafafadf",
                "name"=>"adfasdfafasfasfasfaffasdfasfadsfasfasfasf",
                "comment"=>"asssssssssfddsafasasfasdfasdf"
            ]
        );

        $response->assertSee("ユーザーIDには20文字以下の文字列を指定してください。");
        $response->assertSee("名前には15文字以下の文字列を指定してください。");
    }

    public function testMypageEdit3()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "asfasdfasfasfasfdasf"=>"ueda1234",
                "nasfasfasfasfafaf"=>"ueda",
                "commenafasfdasfasfasfasfdasfast"=>"上田です"
            ]
        );

        $response->assertSee("ユーザーIDは必須です。");
        $response->assertSee("名前は必須です。");
    }

    public function testMypageEdit4()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "adfasfdasfasdfas"
            ]
        );

        $response->assertSee("ユーザーIDは必須です。");
        $response->assertSee("名前は必須です。");
    }

    public function testMypageEdit5()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "userID"=>"ueda1234",
                "name"=>"ueda",
                "comment"=>"上田です",
                "dafasfa" => "asfasfasdfasf"
            ]
        );

        $response->assertSee("");
    }

    public function testMypageEdit6()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "userID"=>NULL,
                "name"=>NULL,
                "comment"=>NULL
            ]
        );

        $response->assertSee("ユーザーIDは必須です。");
        $response->assertSee("名前は必須です。");
    }

    public function testMypageEdit7()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "userID"=>"aaaaaaaa",
                "name"=>"aaaa",
                "comment"=>""
            ]
        );

        $response->assertDontSee("errors");
    }

//表示画面
    public function testMypageShow1()
    {
        $testUser = DB::table("users")->first();
        session()->put('id',$testUser->id);
        $response = $this->get("/mypage");
        $response->assertSee("aaaaaaaa");
        $response->assertSee("aaaa");
    }
}
