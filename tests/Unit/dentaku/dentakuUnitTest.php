<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class dentakuUnitTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     *
     */

    // public function testDates(){
    //     $this->testCount([
    //         "param" =>
    //         [
    //             "kigouArray" => ["+","-"],
    //             "array" => ["3","6","2"],
    //         ],
    //     ]);
    // }

    // public function testCount($params)
    // {
    //     $count = new \App\Http\Controllers\DentakuController();
    //     $resultDTO = $count->sendData($params);
    //     dd($resultDTO);
    // }

    /**
     * @dataProvider additionProvider
     */

    // public function testDelete(){
    //     DB::table("users")->delete();
    //     DB::table("answers")->delete();
    //     DB::table("delAnswers")->delete();
    // }

    public function testAdd($a, $b, $expected)
    {
            $request = array(
                "kigouArray" => $a,
                "array" => $b,
            );

            $response = $this->json
            (
                "POST",
                "sendData",
                [
                "param" => [
                    "kigouArray" => $a,
                    "array" => $b,
                ]
                ]
            );

           $this->assertDatabaseHas("answers",
                [
                    "result"=>$expected
                ]
           );

    }

    public function additionProvider()
    {
        return [
            [[" + "," - "], ['1',"2","1"], 2],
            [["*","+"," - ","/"],["2.22","3.5","9999.9","100","3.3"],3002.3242424242426],
            [["*","+","-","/"],["-55","-33","-2.45","-9.9999999","4"],455.63749997499997],
            [["*","*","*","*"],["99999","99999","-99999","99999","99999"],-9.9995000099999E+24],
            [["+","*"],["55.555","33.22","-2.45"],-217.49875000000003],
            [["*","/"],["9","6","53"],1.0188679245283019],
            [["-","+"],["3.3333","555","-2.44444"],-554.11114],
        ];
    }

}