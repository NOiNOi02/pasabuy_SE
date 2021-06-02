<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;


class resetPasswordController extends Controller
{
    //
    use ResetsPasswords;

    protected function sendResetResponse(Request $request, $response)
    {
        
        return response(['message' => trans($response)]);
    }



    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['error'=>trans($response)], 422);
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        // $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        // $this->guard()->login($user);
    }
}
