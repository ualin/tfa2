<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    private $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pass)
    {
        $this->password = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.otp',['password'=>$this->password])
        ->from('otp@tfa.com')
        ->subject('Two factor authentication');
    }
}
