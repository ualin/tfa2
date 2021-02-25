<?php

namespace Tests\Feature;

use App\Mail\OTPMail;
use App\Notifications\TwoFactor;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class TwoFactorNotificationTest extends TestCase
{
    /** @test */
    public function after_login_mail_is_sent_to_user_with_mail_preference()
    {
        Notification::fake();
        $user = factory(User::class)->create();

        $res=$this->post('/login',['username'=>$user->username,'password'=>'secret']);

        Notification::assertSentTo(
            [$user], TwoFactor::class, function($notification,$channels){
                return in_array('mail',$channels);
            }
        );
    }

    /** @test */
    public function after_login_sms_is_sent_to_user_with_sms_preference()
    {
        Notification::fake();
        $user = factory(User::class)->create(['prefer_sms'=>1]);

        $res=$this->post('/login',['username'=>$user->username,'password'=>'secret']);

        Notification::assertSentTo(
            [$user], TwoFactor::class, function($notification,$channels)use($user){
                return in_array('sms',$channels);
            }
        );
    }
}
