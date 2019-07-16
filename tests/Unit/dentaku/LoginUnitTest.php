<?php

namespace Tests\Unit\dentaku;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Session;

class LoginUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

     /**
     * @dataProvider additionProviderSignUp
     */
    public function testSignUp($userID,$name,$password)
    {
        $response = $this->json(
            'POST',
            '/signUp',
            [
                "userID"=>$userID,
                "name"=>$name,
                "password"=>$password,
            ]
        );

        $this->assertDatabaseHas("users",
            [
                "user_id"=>$userID,
                "name"=>$name,
            ]
        );
    }

    /**
     * userID 重複なし 最小6文字 最大20文字 半角英数字 必須
     * name 最大15文字 半角英数字 必須
     * password 最小6文字 最大20文字 半角英数字 必須
     */
    public function additionProviderSignUp()
    {
        return[
            ["tanakatanaka","tanaka","tanaka1234"],
            ["tanakata","tanaka","tanaka1234"],
            ["123456789123456789","1234567891234","123456789123456789"],
            ["aiaiaiaiaiaiaiaiaiai","aiaiaiaiaiaiaia","aiaiaiaiaiaiaiaiaiai"],
        ];
    }

    /**
     * @dataProvider additionProviderSignIn
     */
    public function testSignIn($userID,$password)
    {
        $response = $this->json(
            'POST',
            '/signIn',
            [
                "userID"=>$userID,
                "password"=>$password,
            ]
        );

        $this->assertSame(Session::get("user_id"),$userID);
    }

    public function additionProviderSignIn()
    {
        return[
            ["tanakatanaka","tanaka1234"],
            ["tanakata","tanaka1234"],
            ["123456789123456789","123456789123456789"],
            ["aiaiaiaiaiaiaiaiaiai","aiaiaiaiaiaiaiaiaiai"],
        ];
    }
}
