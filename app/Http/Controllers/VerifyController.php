<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    //VERIFY USER AFTER REGISTRATION
    public function verify($token) {
      User::where('email_token', $token)
           ->firstOrFail()
           ->update([
                     'email_token' => null,
                     'verified' => 1
           ]);

      //$user->update(['email_token' => null]);
      /*$email_token_update = $user->email_token = null;
        $email_token_update->save(); */

      return redirect('/home')->with('successfulVerification', 'Account Verified!');

    }
}
