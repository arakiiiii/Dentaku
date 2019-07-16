<?php

namespace Tests\Feature\dentaku;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Session;

class LoginFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

// SignUpの正常値

    public function testSignUp1()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "userID"=>"ueda1234",
                "name"=>"ueda",
                "password"=>12341234,
            ]
        );

        $this->assertDatabaseHas("users",
            [
                "user_id"=>"ueda1234",
                "name"=>"ueda",
            ]
            );

        $response->assertDontSee("errors");

    }

    //SignUpの異常値

    public function testSignUp2()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "userID"=>"ueda1234",
                "name"=>"ueda",
                "password"=>12341234,
            ]
        );

        $response->assertSee("errors");

    }

    public function testSignUp3()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "userID"=>"あああああああああああああああああああああああ",
                "name"=>"eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee",
                "password"=>null,
            ]
        );

        $response->assertSee("errors");

    }

    public function testSignUp4()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
            ]
        );

        $response->assertSee("errors");

    }

    public function testSignUp5()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "udfasfaf"=>22222222222222222222222,
                "afasdfas"=>111111111111111111111111,
                "faasdfasdfasfasdfasdf"=>12341234,
                "faasdfasdfasfasdfasdf"=>12341234,
                "faasdfasdfasfasdfasdf"=>12341234,
            ]
        );

        $response->assertSee("errors");

    }

    public function testSignUp6()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "userID"=>null,
                "name"=>null,
                "password"=>null,
            ]
        );

        $response->assertSee("errors");

    }
    public function testSignUp7()
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "userID"=>"kamite1234",
                "name"=>"1",
                "name"=>"2",
                "name"=>"3",
                "name"=>"4",
                "name"=>"5",
                "name"=>"6",
                "name"=>"kamite",
                "password"=>12341234,
            ]
        );

        $response->assertDontSee("errors");

    }


//signInの正常値

    public function testSignIn1()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "userID"=>"ueda1234",
                "password"=>12341234,
            ]
            );

        $this->assertSame(Session::get("user_id"),"ueda1234");
    }

    //signInの異常値
    public function testSignIn2()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "userID"=>"fasssssssssssfasdfasfas",
                "password"=>"fafasdfasfasdfafasfa",
            ]
            );

        $response->assertSee("errors");
    }

    public function testSignIn3()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "fasfasdfas"=>"ueda1234",
                "fasfdsafasf"=>12341234,
            ]
            );

        $response->assertSee("errors");
    }

    public function testSignIn4()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "fafasfsadfagasdafsfafsdf"
            ]
            );

        $response->assertSee("errors");
    }

    public function testSignIn5()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "userID"=>null,
                "password"=>null,
            ]
            );

        $response->assertSee("errors");
    }

    public function testSignIn6()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
            ]
            );

        $response->assertSee("errors");
    }

    public function testSignIn7()
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "userID"=>"ueda1234",
                "password"=>12341234,
                "dajsfhjasdfkasdfdasfasd"=>"asfsdfasfafasdfasdfasgdasfasf",
            ]
            );

        $response->assertDontSee("errors");
    }

//ログイン画面

    public function testLoginShow1(){
        $response = $this->get('/login');

        $response->assertViewIs('dentaku.login');
    }

//登録画面

    public function testRegisterShow1()
    {
        $response = $this->get("/register");

        $response->assertViewIs("dentaku.register");
    }

//ログアウト

    public function testLogout1()
    {
        $response = $this->get("logout");

        $this->assertSame(Session::get("user_id"),NULL);
        $this->assertSame(Session::get("name"),NULL);
        $this->assertSame(Session::get("id"),NULL);

        $response->assertRedirect("login");
    }

}
