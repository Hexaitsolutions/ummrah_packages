<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin;
use App\Agency;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Mail\AgentResetPasswordMail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Twilio\Rest\Client;

class LoginController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

	use AuthenticatesUsers;
	//    use VerifiesEmails;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	protected $twilio;

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
		$this->twilio = new Client(config('custom.TWILIO_SID'), config('custom.TWILIO_AUTH_TOKEN'));
	}
	public function register()
	{
		return view('auth.register');
	}
	public function signup(Request $request)
	{
		if ($request->role == "agent" && $request->route()->getPrefix() == "api") {
			try {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:255',
					//						'email' => 'required|string|email|max:255|unique:admins,email',
					'password' => 'required|string|min:6',
					'agency_name' => 'required|string|max:255',
					'phone' => 'required',
				]);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$user = new Admin;
				$user->surname = $request->surname ?? '';
				$nameParts = explode(' ', $request->name);
				$user->first_name = $nameParts[0] ?? '';
				$user->last_name = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';
				$user->username = $request->first_name . '_' . $request->last_name . '_' . $request->phone ?? '';
				//					$user->email = $request->email;
				$user->phone = $request->phone;
				$user->remember_token = Str::random(80);
				$user->password = bcrypt($request->password);
				$user->status = 'inactive';
				$user->save();
				if (!$user->exists) {
					return response()->json(['error' => 'User creation failed'], 500);
				}

				if ($request->hasFile('agency_image')) {
					$storagepath = $request->file('agency_image')->store('public/packege');
					$fileName = basename($storagepath);
					$baseUrl = env('APP_URL');
					$fullImagePath = Storage::url($storagepath);
					$agency_img = $fullImagePath;
				}
				$agency = new Agency();
				$agency->user_id = $user->id;
				$agency->name = $request->agency_name;
				//					$agency->email =$request->email;
				$agency->img = $agency_img ?? '';
				$agency->phone = $request->phone;
				$agency->save();
				$user->assignRole("agent");
				//					$user->sendAgentApiEmailVerificationNotification();

				return response()->json([
					'success' => true,
					'status' => 'success',
					'message' => 'Account created succcessfully.'
				]);
			} catch (\Exception $e) {
				return response()->json([
					'error' => 'User creation failed',
					'message' => $e->getMessage()
				], 500);
			}
		} else if ($request->role == "agent") {
			try {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:255',
					//						'email' => 'required|string|email|max:255|unique:admins,email',
					'password' => 'required|string|min:6',
					'agency_name' => 'required|string|max:255',
					'phone' => 'required',
				]);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$user = new Admin;
				$user->surname = $request->surname ?? '';
				$nameParts = explode(' ', $request->name);
				$user->first_name = $nameParts[0] ?? '';
				$user->last_name = isset($nameParts[1]) ? implode(' ', array_slice($nameParts, 1)) : '';
				$user->username = $request->first_name . '_' . $request->last_name . '_' . $request->phone ?? '';
				//					$user->email = $request->email;
				$user->remember_token = Str::random(80);
				$user->password = bcrypt($request->password);
				$user->phone = $request->phone;
				$user->status = 'inactive';
				$user->save();
				if (!$user->exists) {
					return response()->json(['error' => 'User creation failed'], 500);
				}

				if ($request->hasFile('agency_image')) {
					$storagepath = $request->file('agency_image')->store('public/packege');
					$baseUrl = env('APP_URL');
					$fullImagePath = Storage::url($storagepath);
					$agency_img = $fullImagePath;
				}
				$agency = new Agency();
				$agency->user_id = $user->id;
				$agency->name = $request->agency_name;
				//					$agency->email =$request->email;
				$agency->img = $agency_img ?? '';
				$agency->phone = $request->phone;
				$agency->save();
				$user->assignRole("agent");
				//					$user->sendAgentApiEmailVerificationNotification();

				return response()->json([
					'success' => true,
					'status' => 'success',
					'message' => 'Account created succcessfully.'
				]);
			} catch (\Exception $e) {
				return response()->json([
					'error' => 'User creation failed',
					'message' => $e->getMessage()
				], 500);
			}
		} else if (($request->role == "customer" || $request->role == null) && $request->route()->getPrefix() == "api") {

			try {
				$validator = Validator::make($request->all(), [
					'name' => 'required|max:255',
					//					'email' => 'required|string|email|max:255|unique:users,email',
					'password' => 'required|string|min:6',
					'phone' => 'required',
				]);
				if ($validator->fails()) {
					return response()->json(['errors' => $validator->errors()], 422);
				}

				$ip = getVisIpAddr();
				$getvalue =  getVisIpDetails($ip);

				$user = new User();
				$user->name = $request->name;
				//				$user->email =$request->email;
				$user->password = bcrypt($request->password);
				$user->remember_token = Str::random(80);
				$user->ip = $ip;
				$user->country = $getvalue->geoplugin_countryName;
				$user->city = $getvalue->geoplugin_city;
				$user->continent = $getvalue->geoplugin_continentName;
				$user->latitude = $getvalue->geoplugin_latitude;
				$user->longitude = $getvalue->geoplugin_longitude;
				$user->currency_symbol = $getvalue->geoplugin_currencySymbol;
				$user->currency_code = $getvalue->geoplugin_currencyCode;
				$user->timezone = $getvalue->geoplugin_timezone;
				$user->phone = $request->phone;
				$user->save();
				//				$user->sendApiEmailVerificationNotification();
				if ($request->route()->getPrefix() == "api") {
					return response()->json([
						'success' => "Account created Succcessfull.",
					]);
				} else {
					return response()->json(['success' => "Account cannot be created"]);
				}
			} catch (\Exception $e) {
				return response()->json([
					'error' => 'User creation failed',
					'message' => $e->getMessage()
				], 500);
			}
		} else if (($request->role == "customer" || $request->role == null)) {

			$validator = Validator::make($request->all(), [
				'name' => 'required|max:255',
				//				'email' => 'required|string|email|max:255|unique:users,email',
				'password' => 'required|string|min:6|confirmed',
				'phone' => ['required', 'phone:AUTO']
			]);

			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 422);
			}

			$ip = getVisIpAddr();
			$getvalue =  getVisIpDetails($ip);

			$user = new User();
			$user->name = $request->name;
			//			$user->email =$request->email;
			$user->password = bcrypt($request->password);
			$user->remember_token = Str::random(80);
			$user->ip = $ip;
			$user->country = $getvalue->geoplugin_countryName;
			$user->city = $getvalue->geoplugin_city;
			$user->continent = $getvalue->geoplugin_continentName;
			$user->latitude = $getvalue->geoplugin_latitude;
			$user->longitude = $getvalue->geoplugin_longitude;
			$user->currency_symbol = $getvalue->geoplugin_currencySymbol;
			$user->currency_code = $getvalue->geoplugin_currencyCode;
			$user->timezone = $getvalue->geoplugin_timezone;
			$user->phone = $request->phone;
			$user->save();
			// $user->sendApiEmailVerificationNotification();
			return response()->json([
				'success' => "Account created succcessfully.",
			]);
		}
	}

	public function resend_verification_email(Request $request)
	{
		try {
			$validator = Validator::make($request->all(), [
				'role' => 'required|in:agent,customer',
				'email' => 'required|string|email|max:255'
			]);
			if ($validator->fails()) {
				return response()->json(['errors' => $validator->errors()], 422);
			}
			if ($request->role == "agent") {
				$Agent = Admin::where('email', $request->email)->first();
				if (!$Agent) {
					return response()->json(['error' => 'Agent Not Found'], 404);
				}
				$Agent->sendAgentApiEmailVerificationNotification();
				return response()->json([
					'success' => true,
					'status' => 'success',
					'message' => 'Please verify your email by clicking on verify user button sent to you on your email'
				]);
			} else if ($request->role == "customer" || $request->role == null) {
				$user = User::where('email', $request->email)->first();
				if (!$user) {
					return response()->json(['error' => 'User Not Found'], 404);
				}
				$user->sendApiEmailVerificationNotification();
				return response()->json([
					'success' => true,
					'status' => 'success',
					'message' => 'Please verify your email by clicking on verify user button sent to you on your email'
				]);
			}
		} catch (\Exception $e) {
			return response()->json([
				'error' => 'Something went Wrong',
				'message' => $e->getMessage()
			], 500);
		}
	}



	public function login(Request $request)
	{
	
		if ($request->route()->getPrefix() == "api") {
			if ($request->role == "agent") {
				if (! $request->phone || ! $request->password || ! $request->role) {
					return response()->json([
						'error' => "Username, password , and role are required",
					], 400);
				}
				if (Auth::guard('admin')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
					$admin = Auth::guard('admin')->user();


					if ($admin) {
						$admin = Admin::find($admin->id);
						$admin['roles'] = $admin->roles()->get();

						$isAdminAgent = $admin['roles']->contains('name', 'agent');
						if ($isAdminAgent) {
							$admin['agency'] = $admin->agency; // Retrieve the agency details
						}
					}

					return response()->json([
						'message' => "Login Successfull!",
						"user" => $admin,
						"token" =>  $admin->remember_token,
					]);
				} else {
					return response()->json([
						'error' => "Incorrect phone or password",
					], 400);
				}
			} else {
				if (! $request->phone || ! $request->password) {
					return response()->json([
						'error' => "Username and password are required",
					], 400);
				}
				if (Auth::guard('user')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
					$user = Auth::guard('user')->user();
					if ($user == null) {
						return response()->json([
							'error' => "User Does not exist",
						], 400);
					}
					// if($user->email_verified_at == null) {
					// 	return response()->json([
					// 		'error' => "Account is not verified. Please check your email to verify.",
					// 	], 400);
					// }
					return response()->json([
						'message' => "Login Successfull!",
						"user" => $user,
						"token" => $user->remember_token,
					]);
				} else {
					return response()->json([
						'error' => "Incorrect phone or password",
					], 400);
				}
			}
		} elseif ($request->role == "agent") {
			if (! $request->email || ! $request->password || ! $request->role) {
				return response()->json([
					'error' => "Username, password , and role are required",
				], 400);
			}
			return response()->json(['error' => true, 'status' => 'success', 'message' => _lang('Your are not allowed to login')]);
		} else {
			
			$phone = $request->phone;

			$code = strval(rand(1000, 9999)); // Generate a random 4-digit code
			$this->validate($request, ['phone' => 'required', 'password' => 'required']);
			if (Auth::guard('user')->attempt(['phone' => $phone, 'password' => $request->password])) {

				$user = Auth::guard('user')->user();

				if (is_null($user->verified_at)) {
					// Log the user out immediately since they are not verified
					Auth::guard('user')->logout();

					// Send verification message via Twilio
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

					// Save the verification code to the user's record
					$user->verification_code = $code;
					$user->save();



					// Return a response asking the user to verify their phone number
					return response()->json([
						'success' => false,
						'status' => 'verify',
						'message' => 'Your phone number is not verified. Please verify it to continue.',
					]);
				}

				return response()->json(['success' => true, 'status' => 'success', 'message' => _lang('Login Successfull')]);
			} else {
				return response()->json(['success' => false, 'status' => 'danger', 'message' => _lang('Incorrect username or password')]);
			}
		}
	}
	public function verifyPhone(Request $request)
	{
		// Validate input
		$request->validate([
			'code' => 'required|string|max:4',
		]);

		// Find the user by phone number
		$user = User::where('phone', $request->phone)->first();

		if (!$user) {
			return response()->json(['success' => false, 'message' => 'Phone number not found.']);
		}

		// Check if the verification code matches
		if ($user->verification_code == $request->code) {

			// If the code matches, log the user in
			Auth::guard('user')->login($user);

			// Optionally, you can clear the phone_verification_code after successful verification
			$user->verification_code = null;
			$user->verified_at = now();
			$user->save();

			return response()->json(['success' => true, 'message' => 'Phone verified and logged in successfully!']);
		} else {
			// If the code is wrong
			return response()->json(['success' => false, 'message' => 'Wrong verification code.']);
		}
	}

	public function get_agent_details(Request $request, $id)
	{
		try {
			$token = $request->bearerToken();
			if (!$token) {
				return response()->json(['error' => 'Unauthorized'], 401);
			}
			if (!$id) {
				return response()->json(['error' => "Id is required"], 422);
			}
			$agent = Admin::where('id', $id)->first();
			if (!$agent) {
				return response()->json(['message' => 'User Not Found'], 403);
			}
			if ($agent->remember_token != $token) {
				return response()->json(['message' => 'Sorry Token Mismatched'], 403);
			}
			$agent['roles'] = $agent->roles()->get();
			$isAdminAgent = $agent['roles']->contains('name', 'agent');
			if ($isAdminAgent) {
				$agent['agency'] = $agent->agency; // Retrieve the agency details
			}
			return response()->json([
				'message' => "Agent Reterived Successfull!",
				"user" => $agent,
				"token" =>  $agent->remember_token,
			]);
		} catch (\Exception $e) {
			return response()->json([
				'error' => 'Agent Retrieved failed',
				'message' => $e->getMessage()
			], 500);
		}
	}


	public function logout(Request $request)
	{
		$this->guard()->logout();

		$request->session()->invalidate();

		return $this->loggedOut($request) ?: redirect('/');
	}

	public function apilogout(Request $request)
	{
		return response()->json("Logout Successfully");
	}

	public function delete_user(Request $request)
	{
		$user_token = $request->header('token');
		if (! $user_token) {
			return response()->json(['error' => "Bad request! Provide access token"], 403);
		}
		$access = User::where('remember_token', $user_token)->first();
		if ($access == null) {
			return response()->json(['error' => "Invalid token"], 403);
		}
		$user = User::find($access->id);
		$user->delete();
		return response()->json([
			'sucess' => "User account deleted successfully",
		]);
	}

	public function update(Request $request)
	{
		if ($request->route()->getPrefix() == "api") {
			$user_token = $request->header('token');
			$access = User::where('remember_token', $user_token)->first();
			$access_for_agent = Admin::where('remember_token', $user_token)->first();
			if ($access === null && $access_for_agent === null) {
				return response()->json(['error' => "Invalid token"], 403);
			}

			$user = $access ? User::find($access->id) : ($access_for_agent ? Admin::find($access_for_agent->id) : null);
			if ($user) {

				if ($request->name) {
					$user->name = $request->name;
				}
				if ($request->phone) {
					$user->phone = $request->phone;
				}
				if ($request->password) {
					$user->password = Hash::make($request->password);
				}
				// if($request->email){
				//   $user->email =$request->email;
				// }
				$user->save();
				return response()->json(['sucess' => "User information updated successfully", "user" => $user]);
			} else {
				return response()->json(['sucess' => "user not found"]);
			}
		} else {
			$user = User::find($request->user_id);
			if ($user) {
				if ($request->password) {
					$user->password = Hash::make($request->password);
					// $user->remember_token =Str::random(80);
				}
				$user->name = $request->name;
				$user->email = $request->email;
				$user->phone = $request->phone;
				$user->save();
			}
			return redirect()->back();
		}
	}

	public function customerSendResetLink(Request $request)
	{
		// $token = $request->bearerToken();
		// if (!$token) {
		// 	return response()->json(['error' => 'Unauthorized'], 401);
		// }
		if (!$request->has('email')) {
			return response()->json(['error' => "Email is required"], 422);
		}
		$user = User::where('email', $request->email)->first();
		if (!$user) {
			return response()->json(['message' => 'Email not found'], 404);
		}
		// if ($user->remember_token != $token) {
		// 	return response()->json(['message' => 'Sorry Token Mismatched'], 403);
		// }
		$resetToken = Str::random(60);
		$user->update(['reset_token' => $resetToken, 'token_expiry' => now()->addMinutes(60)]);
		$user->save();
		Mail::to($user->email)->send(new ResetPasswordMail($user));
		return response()->json(['message' => 'Reset link sent to your email']);
	}

	public function CustomerResetPassword(Request $request)
	{
		$user = User::where('email', $request->email)
			->first();
		if (!$user) {
			return response()->json(['message' => 'Invalid or expired reset token'], 400);
		}
		$user->update(['password' => bcrypt($request->password), 'reset_token' => null, 'token_expiry' => null]);
		return response()->json(['message' => 'Password reset successful']);
	}

	// agent
	public function agentSendResetLink(Request $request)
	{
		// $token = $request->bearerToken();
		// if (!$token) {
		// 	return response()->json(['error' => 'Unauthorized'], 401);
		// }
		if (!$request->has('email')) {
			return response()->json(['error' => "Email is required"], 422);
		}
		$user = Admin::where('email', $request->email)->first();
		if (!$user) {
			return response()->json(['message' => 'Email not found'], 404);
		}
		// if ($user->remember_token != $token) {
		// 	return response()->json(['message' => 'Sorry Token Mismatched'], 403);
		// }
		$resetToken = Str::random(60);
		// dd($resetToken);
		$user->update(['reset_token' => $resetToken, 'token_expiry' => now()->addMinutes(60)]);
		$user->save();
		Mail::to($user->email)->send(new AgentResetPasswordMail($user));
		return response()->json(['message' => 'Reset link sent to your email']);
	}

	public function agentResetPassword(Request $request)
	{
		$user = Admin::where('email', $request->email)
			->first();
		if (!$user) {
			return response()->json(['message' => 'Invalid or expired reset token'], 400);
		}
		$user->update(['password' => bcrypt($request->password), 'reset_token' => null, 'token_expiry' => null]);
		return response()->json(['message' => 'Password reset successful']);
	}

	public function getUserDetails(Request $request, $id)
	{
		try {
			$token = $request->bearerToken();
			if (!$token) {
				return response()->json(['error' => 'Unauthorized'], 401);
			}
			if (!$id) {
				return response()->json(['error' => "Id is required"], 422);
			}
			$user = User::where('id', $id)->first();
			if (!$user) {
				return response()->json(['message' => 'User Not Found'], 403);
			}
			if ($user->remember_token != $token) {
				return response()->json(['message' => 'Sorry Token Mismatched'], 403);
			}

			return response()->json([
				'message' => "User Reterived Successfull!",
				"user" => $user,
				"token" =>  $user->remember_token,
			]);
		} catch (\Exception $e) {
			return response()->json([
				'error' => 'Agent Retrieved failed',
				'message' => $e->getMessage()
			], 500);
		}
	}

	public function updateProfilePicture(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'image' => 'mimes:jpeg,png,jpg,gif|max:2048'
		]);

		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()], 422);
		}

		$user = User::where('remember_token', $request->header('token'))->first();
		if ($user) {
			if ($request->hasFile('image')) {
				if ($user->img) {
					// Extracting filename from the URL
					$filename = basename($user->img);
					Storage::delete('public/profile/' . $filename);
				}
				$storagepath = $request->file('image')->store('public/profile');
				$baseUrl = config('app.url');
				$fullImagePath =  Storage::url($storagepath);
				$user->img = $fullImagePath;
				$user->save();
				return response()->json(['success' => true, 'status' => 'success', 'message' => "Profile picture updated successfully"]);
			}
		} else {
			return response()->json(['success' => false, 'status' => 404, 'message' => "User not exists"]);
		}
	}

	// public function redirectToGoogle()
	// {
	//     return Socialite::driver('google')->redirect();
	// }

	public function loginWithGoogle(Request $request)
	{
		try {
			$token = $request->token_id;
			$user = Socialite::driver('google')->userFromToken($token);
			if ($user) {
				$user_exists = User::where('google_id', $user->id)->first();
				if ($user_exists) {
					Auth::guard('user')->login($user_exists);
					$user_token = $user_exists->createToken('ummrah')->accessToken;
					return response()->json([
						'message' => "Login Successfull!",
						"user" => $user_exists,
						"token" => $user_token,
					]);
				} else {
					$ip = getVisIpAddr();
					$getvalue =  getVisIpDetails($ip);

					$new_user = User::updateOrCreate(['email' => $user->email], [
						'name' => $user->name,
						'google_id' => $user->id,
						'password' => encrypt(Str::random(8)),
						'remember_token' => Str::random(80),
						'ip' => $ip,
						'country' => $getvalue->geoplugin_countryName,
						'city' => $getvalue->geoplugin_city,
						'continent' => $getvalue->geoplugin_continentName,
						'latitude' => $getvalue->geoplugin_latitude,
						'longitude' => $getvalue->geoplugin_longitude,
						'currency_symbol' => $getvalue->geoplugin_currencySymbol,
						'currency_code' => $getvalue->geoplugin_currencyCode,
						'timezone' => $getvalue->geoplugin_timezone,
						'email_verified_at' => $user['email_verified'] ? Carbon::now() : null,
					]);
					Auth::guard('user')->login($new_user);
					$user_token = $new_user->createToken('ummrah')->accessToken;
					return response()->json([
						'message' => "Login Successfull!",
						"user" => $new_user,
						"token" => $user_token,
					]);
				}
			}
		} catch (ClientException $e) {
			return response()->json(['error' => "Token expired: " . $e->getMessage()], 500);
		}
	}

	public function agentLoginWithGoogle(Request $request)
	{
		try {
			$token = $request->token_id;
			$agent = Socialite::driver('google')->userFromToken($token);
			if ($agent) {
				$agent_exists = Admin::where('google_id', $agent->id)->first();
				if ($agent_exists) {
					Auth::guard('admin')->login($agent_exists);
					$agent_token = $agent_exists->createToken('ummrah')->accessToken;
					return response()->json([
						'message' => "Login Successfull!",
						"user" => $agent_exists,
						"token" => $agent_token,
					]);
				} else {
					$new_agent = Admin::updateOrCreate(['email' => $agent->email], [
						'first_name' => $agent['given_name'],
						'last_name' => $agent['family_name'],
						'google_id' => $agent->id,
						'status' => 'inactive',
						'password' => encrypt(Str::random(8)),
						'remember_token' => Str::random(80),
						'email_verified_at' => $agent['email_verified'] ? Carbon::now() : null,
					]);
					Auth::guard('admin')->login($new_agent);
					$agent_token = $new_agent->createToken('ummrah')->accessToken;
					$agency = new Agency();
					$agency->user_id = $new_agent->id;
					$agency->email = $agent->email;
					$agency->save();
					$new_agent->assignRole("agent");

					return response()->json([
						'message' => "Login Successfull!",
						"user" => $new_agent,
						"token" => $agent_token,
					]);
				}
			}
		} catch (ClientException $e) {
			return response()->json(['error' => "Token expired: " . $e->getMessage()], 500);
		}
	}
}
