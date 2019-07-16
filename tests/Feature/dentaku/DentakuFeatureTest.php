<?php

namespace Tests\Feature\dentaku;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class DentakuFeatureTest extends TestCase
{

    //Unitで計算をたくさん実験する
    //mySQLテストをする

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testSendData1()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'kigouArray' => ["+","-"],
                    'array' => ["3","6","5"],
                    ]
            ]
        );

        $this->assertDatabaseHas("answers",
            [
                "answer" => "3 + 6 - 5 = 4",
                "result" => "4"
            ]
        );

        $response->assertJson(
            [
                "results" => [
                    0 => [
                        "answer"=> "3 + 6 - 5 = 4",
                        "user_id"=> null,
                        "result"=> "4"
                    ]
                ]
            ]
        );
    }

    public function testSendData2()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'kigouArray' => ["+","-","*","/"],
                    'array' => ["300","60000","5",'22',"34"],
                    ]
            ]
        );

        $this->assertDatabaseHas("answers",
            [
                "answer" => "300 + 60000 - 5 × 22 ÷ 34 = 39014.411764706",
                "result" => "39014.41176470588"
            ]
        );

        $response->assertJson(
            [
                "results" => [
                    0 => [
                        "answer"=> "300 + 60000 - 5 × 22 ÷ 34 = 39014.411764706",
                        "user_id"=> null,
                        "result"=> "39014.41176470588"
                    ]
                ]
            ]
        );
    }

    public function testSendData3()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'kigouArray' => ["aaa","bbb","+"],
                    'array' => ["300","60000","5",'22'],
                    ]
            ]
        );

        $response->assertStatus(200)->assertViewHas(
       	    [
           ]);
    }

    public function testSendData4()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'kigouArray' => ["aaa","bbb","+"],
                    'array' => ["aaaa","+++","aa",'22'],
                    ]
            ]
        );

        $response->assertStatus(200)->assertViewHas(
       	    [
                "results" => NULL,
                'errors' => [
                    'array.0' => ['1個目の数字には数値を指定してください。'],
                    'array.1' => ['2個目の数字には数値を指定してください。'],
                    'array.2' => ['3個目の数字には数値を指定してください。'],
                    'kigouArray.0' => ['正しい形式の1個目の記号を指定してください。'],
                    'kigouArray.1' => ['正しい形式の2個目の記号を指定してください。'],
                    ]
           ]);
    }

    public function testSendData5()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'array' => ["aaaa","+++","aa",'22'],
                    'kigouArray' => [],
                    ]
            ]
        );

        $response->assertStatus(200)->assertViewHas(
       	    [
                "results" => NULL,
                'errors' => [
                    'kigouArray' => ['記号は必須です。'],
                    'array.0' => ['1個目の数字には数値を指定してください。'],
                    'array.1' => ['2個目の数字には数値を指定してください。'],
                    'array.2' => ['3個目の数字には数値を指定してください。'],
                ],
           ]);
    }

    public function testSendData6()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'afasdf' => "aaaaふぁｆｄさふぁ",
                    'fafasdf' => "asdfadsfsdfaf",
                ],
            ]
        );

        $response->assertStatus(200)->assertViewHas(
       	    [
                "results" => NULL,
                'errors' => [
                    'kigouArray'=>['記号は必須です。'],
                    'array'=>['計算式は必須です。']
                ],
           ]);
    }

    public function testSendData7()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "afdasdfdasfgrgrv","adfe","9999999999999999999999999999999999"
            ]
        );

        $response->assertViewHas(
       	    [
                "results" => NULL,
                'errors' => [
                    'param'=>['計算式は必須です。'],
            ],
           ]);
    }

    public function testSendData8()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
            ]
        );

        $response->assertViewHas(
       	    [
                "results" => NULL,
                'errors' => [
                    'param'=>['計算式は必須です。'],
            ],
           ]);
    }

     public function testSendData9()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'array' => "888888aaaaaaaaa",
                    'kigouArray' => "++++++++++++++++",
                ],
            ]
        );

        $response->assertViewHas(
       	    [
                "results" => NULL,
                'errors' => NULL
           ]);
    }

    public function testSendData10()
    {
        $response = $this->json(
            'POST',
            '/sendData',
            [
                "param" => [
                    'array' => ["29","10"],
                    'kigouArray' => ["++++++++++++++++"],["-"]
                ],
            ]
        );

        $response->assertViewHas(
       	    [
                "results" => NULL,
                "errors" => [
                    'kigouArray.0' => ["正しい形式の1個目の記号を指定してください。"],
                ]
           ]);
    }


    public function testHome1()
    {
        $response = $this->json(
            'GET',
            '/home',
            [
            ]
        );

        $response->assertStatus(200)->assertViewHas([
                    "errors" => null,
            ]);
    }

     public function testHome2()
     {
        $response = $this->json(
            'GET',
            '/home',
            [
            ]
        );

        $this->assertDatabaseHas("answers",
            [
                "answer" => "3 + 6 - 5 = 4",
                "answer" => "300 + 60000 - 5 × 22 ÷ 34 = 39014.411764706"
            ]
        );

    }

    public function testHome3()
    {
        $response = $this->json(
            'GET',
            '/home',
            [
            ]
        );

        $response->assertStatus(200)->assertViewHas([
                    "errors" => null,
            ]);
    }

    public function testDeleteData()
    {
        $response = $this->json(
            'POST',
            '/deleteData',
            [
            ]
        );

        $this->assertDatabaseMissing("answers",
            [
                "answer" => "3 + 6 - 5 = 4",
                "answer" => "300 + 60000 - 5 * 22 / 34 = 39014.411764706"
            ]
        );
    }

}
