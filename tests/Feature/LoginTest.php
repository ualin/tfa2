<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_access_login_route()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
    
    /** @test */
    public function unauthenticated_user_cannot_acccess_home_route()
    {
        $user = factory(User::class)->create();

        $this->get('/home')->assertRedirect('/login');
    }

    /** @test */
    public function user_cannot_access_home_route_after_login_if_not_verified()
    {
        $user = factory(User::class)->create(['two_factor_pass'=>'123456','two_factor_expires_at'=>now()->addSeconds(120)]);

        $this->actingAs($user);

        $this->get('/home')->assertRedirect('/otp');
    }
    
    /** @test */
    public function user_cannot_access_home_route_after_login_if_the_two_factor_pass_expired()
    {
        $user = factory(User::class)->create(['two_factor_pass'=>'123456','two_factor_expires_at'=>now()->subSeconds()]);

        $this->actingAs($user);

        $this->get('/home')->assertRedirect('/login');
    }

}
