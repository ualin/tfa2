<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TwoFactorCodeResendTest extends TestCase
{
    /**
     * @test
     */
    public function after_login_user_cannot_resend_the_auth_code_mode_than_one_time()
    {
        $user = factory(User::class)->create([
            'two_factor_pass'=>'123456',
            'two_factor_expires_at'=>now()->addSeconds(120),
            'two_factor_pass_resend_attempt'=>2
        ]);

        $this->actingAs($user);

        $this->post('/otp/resend')->assertRedirect('/login');
    }
}
