<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OTPController extends Controller
{
    public function index()
    {
        return view('auth.verify');
    }

    public function verifyPass(Request $request)
    {
        $data = $request->validate([
            'two_factor_pass' => 'required|max:6'
        ]);
        $user = auth()->user();

        if($user->two_factor_expires_at->lt(now()))
        {
            return redirect()->back()->withErrors(['otp'=>'The one time password has expired.']);
        }

        if($user->two_factor_pass === $data['two_factor_pass'])
        {
            //two factor otp success
            $user->reset_two_factor_data();

            return redirect('home');
        }
        else
        {
            return redirect()->back()->withErrors(['otp'=>'One time password mismatch.']);
        }
    }
}
