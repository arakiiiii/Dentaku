<?php

namespace Tests\Unit\dentaku;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class MypageUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

     /**
     * @dataProvider additionProviderSignUp
     */
    public function testMypage($userID,$name,$comment)
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->json(
            'POST',
            '/edit',
            [
                "userID"=>$userID,
                "name"=>$name,
                "comment"=>$comment,
            ]
        );

        $this->assertDatabaseHas("users",
            [
                "user_id"=>$userID,
                "name"=>$name,
                "comment"=>$comment,
            ]
        );
    }

    /**
     * userID 重複なし 最小6文字 最大20文字 半角英数字 必須
     * name 最大15文字 半角英数字 必須
     * comment 最大50文字
     **/
    public function additionProviderSignUp(){
        return [
            ["aaaaaaaaaa","aaaaaaa","aaa"],
            ["aiaiai","a",NULL],
            ["12345678901234567890","123456789123456","12345678901234567890123456789012345678901234567890"],
            ["aaaaaaaaaaaaaaaaaaaa","aaaaaaaaaaaaaaa","aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"],
            ["aaaaaaaaaa","aaaa",NULL],
            ["uedaaaaaaaaaaa","ueda","上田です"]
        ];
    }
}
