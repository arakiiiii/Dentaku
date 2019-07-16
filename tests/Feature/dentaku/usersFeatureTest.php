<?php

namespace Tests\Feature\dentaku;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;


class usersFeatureTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUsers1()
    {
        $testUser = DB::table("users")->first();
        session()->put('user_id',$testUser->user_id);
        session()->put('id',$testUser->id);
        $response = $this->get('/users');

        $response->assertSee('kamite');
    }
}