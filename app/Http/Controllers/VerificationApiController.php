<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;

use Illuminate\Foundation\Auth\VerifiesEmails;

use Illuminate\Http\Request;

use Illuminate\Auth\Events\Verified;

class VerificationApiController extends Controller

{

    use VerifiesEmails;

    /**

    * Show the email verification notice.

    *

    */


    /**

    * Mark the authenticated user’s email address as verified.

    *

    * @param \Illuminate\Http\Request $request

    * @return \Illuminate\Http\Response

    */

    public function verify(Request $request)
    {

        $userID = $request['id'];
        $user = User::findOrFail($userID);
        $date = date("Y-m-d g:i:s");
        $user->email_verified_at = $date;
        $user->status = "activated";
        $user->save();
        return response()->json("Email verified!");

    }

    public function verifyAgent(Request $request)
    {
        $userID = $request['id'];
        $user = Admin::findOrFail($userID);
        $date = date("Y-m-d g:i:s");
        $user->email_verified_at = $date;
        $user->save();
        return response()->json("Email verified!");

    }

    /**

    * Resend the email verification notification.

    *

    * @param \Illuminate\Http\Request $request

    * @return \Illuminate\Http\Response

    */

    public function resend(Request $request)

    {

        if ($request->user()->hasVerifiedEmail())
        {
            return response()->json('User already have verified email!', 422);
        }

        $request->user()->sendEmailVerificationNotification();
        return response()->json('The notification has been resubmitted');
    }

}