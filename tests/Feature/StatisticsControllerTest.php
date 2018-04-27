<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use View;

class StatisticsControllerTest extends TestCase
{
    /**
     * @test
     */
    use RefreshDatabase;
    public function user_can_see_statistics()
    {

        $user = factory(User::class)->create();
        View::share('user',$user);
        $response = $this->actingAs($user)->get('statistics');

        $response->assertSuccessful();
    }
}
