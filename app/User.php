<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'two_factor_pass'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
        'two_factor_expires_at',
    ];

    public function generate_two_factor_data()
    {
        $this->timestamps = false;
        $this->two_factor_pass = random_int(100000,999999);
        $this->two_factor_expires_at = now()->addSeconds(120);
        $this->two_factor_pass_resend_attempt = 0;

        $this->save();
    }

    public function regenerate_two_factor_data()
    {
        $this->timestamps = false;
        $this->two_factor_pass = random_int(100000,999999);
        $this->two_factor_pass_resend_attempt += 1;

        $this->save();
    }
    
    public function reset_two_factor_data()
    {
        $this->timestamps = false;
        $this->two_factor_pass = null;
        $this->two_factor_expires_at = null;
        $this->two_factor_pass_resend_attempt = 0;

        $this->save();
    }

    public function increase_two_factor_pass_resend_attempt()
    {
        $this->timestamps = false;
        $this->two_factor_pass_resend_attempt += 1;

        $this->save();
    }
}
