<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SmsController extends Controller
{
    protected $twilio;

    public function __construct()
    {

        $this->twilio = new Client(config('custom.TWILIO_SID'), config('custom.TWILIO_AUTH_TOKEN'));
    }

    public function sendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $phone = $request->phone;
        $code = strval(rand(1000, 9999)); // Generate a random 4-digit code
        $role = $request->role;
        // Determine which table to use based on the role
        if ($role === 'customer') {
            $model = User::where('phone', $phone)->first();
        } elseif ($role === 'agent') {
            $model = Admin::where('phone', $phone)->first();
        } else {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        if (!$model) {
            return response()->json(['error' => 'Phone number not found'], 404);
        }

        // Store the code in the database or session for later verification
        $model->verification_code = $code;
        $model->save();
        // Send the verification code via SMS

        $this->twilio->messages->create(
            "whatsapp:$phone",  // Receiver's WhatsApp number
            [
                'from' => config('custom.TWILIO_PHONE_NUMBER'),  // Your Twilio WhatsApp number
                'contentSid' => config('custom.CONTENT_SID'),  // Your Twilio Content SID
                'contentVariables' => json_encode([
                    '1' => $code  // Ensure '1' matches the placeholder in your template
                ])
            ]
        );


        // Store the code in session or database for later verification


        return response()->json(['message' => 'Verification code sent successfully!', 'otp' => $code]);
    }

    public function verifyCode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'code' => 'required|numeric', // Ensure the code is provided
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $phone = $request->phone;
        $role = $request->role;
        $code = (int)$request->code;

        // Determine which table to use based on the role
        if ($role === 'customer') {
            $model = User::where('phone', $phone)->first();
        } elseif ($role === 'agent') {
            $model = Admin::where('phone', $phone)->first();
        } else {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        if (!$model) {
            return response()->json(['error' => 'Phone number not found'], 404);
        }

        // Check if the verification code matches
        if ($model->verification_code === $code) {
            // Mark the user as verified
            $model->verified_at = now();
            $model->verification_code = null; // Clear the verification code after successful verification
            $model->save();

            return response()->json(['message' => 'Phone number verified successfully!']);
        } else {
            return response()->json(['error' => 'Invalid verification code'], 400);
        }
    }

    public function sendPasswordReset(Request $request)
    {
        // Similar logic to send a password reset SMS with a unique token
    }

    public function requestPasswordReset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $role = $request->role;
        $phone = $request->phone;
        $user = null;

        // Fetch user from the appropriate table based on the role
        if ($role == 'customer') {
            $user = User::where('phone', $request->phone)->first();
        } elseif ($role == 'agent') {
            $user = Admin::where('phone', $request->phone)->first();
        } else {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        // Check if the user exists in the relevant table
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Generate a reset token and set expiry time
        $resetToken = strval(rand(1000, 9999)); // Generate a random 4-digit code
        $user->update(['reset_token' => $resetToken, 'token_expiry' => now()->addHours(1)]);

        // Send SMS using Twilio
        $this->twilio->messages->create(
            "whatsapp:$phone",  // Receiver's WhatsApp number
            [
                'from' => config('custom.TWILIO_PHONE_NUMBER'),  // Your Twilio WhatsApp number
                'contentSid' => config('custom.CONTENT_SID'),  // Your Twilio Content SID
                'contentVariables' => json_encode([
                    '1' => $resetToken  // Ensure '1' matches the placeholder in your template
                ])
            ]
        );
        return response()->json(['message' => 'Reset code sent', 'otp' => $resetToken]);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'reset_token' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $role = $request->role;
        $user = null;

        // Fetch the user from the appropriate table based on the role
        if ($role == 'customer') {
            $user = User::where('phone', $request->phone)
                ->where('reset_token', $request->reset_token)
                ->where('token_expiry', '>', now())
                ->first();
        } elseif ($role == 'agent') {
            $user = Admin::where('phone', $request->phone)
                ->where('reset_token', $request->reset_token)
                ->where('token_expiry', '>', now())
                ->first();
        } else {
            return response()->json(['error' => 'Invalid role'], 400);
        }

        // Check if the user exists and the token is valid
        if (!$user) {
            return response()->json(['error' => 'Invalid token or expired'], 400);
        }

        // Update the user's password and clear the reset token and expiry
        $user->password = bcrypt($request->password);
        $user->reset_token = null; // Clear the token
        $user->token_expiry = null; // Clear the expiration
        $user->save();

        return response()->json(['message' => 'Password reset successfully']);
    }

}
