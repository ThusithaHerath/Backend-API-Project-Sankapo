<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\UserVerify;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\VerifyEmail;
use App\Notifications\Announcement;
use Mail;
use DB;

use function Psy\info;

class AuthController extends Controller
{

	/*
	 * Register new user
	*/
	public function signup(Request $request)
	{
		if (User::where('email', '=', $request->input('email'))->exists()) {
			return response()->json([
				'message' => 'Sorry, User with the provided email is already exists!',
			], 403);
		} else {
			$validated = $request->validate([
				'password' => 'required|min:8|max:12',
				'phonenumber' => 'required|max:10',
				'fullname' => 'required'
			]);

			if ($validated) {
				$user = new User();
				$user->email = $request->input('email');
				$user->password = Hash::make($request->input('password'));
				$user->phonenumber = $request->input('phonenumber');
				$user->nrc = $request->input('nrc');
				$user->fullname = $request->input('fullname');
				$user->province = $request->input('province');
				$user->city = $request->input('city');
				$user->town = $request->input('town');
				$user->dob = $request->input('dob');
				$user->save();

				//create random string for remember token
				$token = Str::random(64);

				//insert remember token to userverify table
				UserVerify::create([
					'user_id' => $user->id,
					'token' => $token
				]);

				$userData = array('token' => $token, 'userData' => $user);
				//send verify email to registered user
				Mail::to($request->input('email'))->send(new VerifyEmail($userData));


				return response()->json([
					'message' => 'New user has been addedd successfully!',
					'data' => $userData
				], 200);
			} else {
				return response()->json([
					'message' => 'Error while adding user!',
				], 500);
			}
		}
	}

	/*
	 * Generate sanctum token on successful login
	*/
	public function login(Request $request)
	{
		$validator = $request->validate([
			'email' => 'required|email',
			'password' => 'required',
		]);

		$user = User::where('email', $request->email)->first();

		if($user){
			if (Hash::check($request->password, $user->password)) {
				return response()->json([
					'user' => $user,
					'message' => 'Successfully logged in!',
					'access_token' => $user->createToken($request->email)->plainTextToken
				], 200);
			}
			else{
				return response()->json([
					'message' => 'Incorrect Password!',
				], 403);
			}
		}
		else{
			return response()->json([
				'user' => $user,
				'message' => 'User not found!',
			], 401);
		}

	}


	/*
	 * Revoke token; only remove token that is used to perform logout (i.e. will not revoke all tokens)
	*/
	public function logout(Request $request)
	{

		// Revoke the token that was used to authenticate the current request
		$request->user()->currentAccessToken()->delete();
		//$request->user->tokens()->delete(); // use this to revoke all tokens (logout from all devices)
		return response()->json(null, 200);
	}


	/*
	 * Get authenticated user details
	*/
	public function getAuthenticatedUser(Request $request)
	{
		return $request->user();
	}


	public function sendPasswordResetLinkEmail(Request $request)
	{
		$request->validate(['email' => 'required|email']);

		$status = Password::sendResetLink(
			$request->only('email')
		);

		if ($status === Password::RESET_LINK_SENT) {
			return response()->json(['message' => __($status)], 200);
		} else {
			throw ValidationException::withMessages([
				'email' => __($status)
			]);
		}
	}

	public function resetPassword(Request $request)
	{
		$request->validate([
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|min:8|confirmed',
		]);

		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user, $password) use ($request) {
				$user->forceFill([
					'password' => Hash::make($password)
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		if ($status == Password::PASSWORD_RESET) {
			return response()->json(['message' => __($status)], 200);
		} else {
			throw ValidationException::withMessages([
				'email' => __($status)
			]);
		}
	}

	public function changePassword(Request $request, $id){
		$userExists = User::where('id','=', $id)->where('role','1')->exists();
		if ($userExists) {
			DB::table('users')->where('id',$id)->update(['password'=>Hash::make($request->password)]);
			return response()->json([
				'message' => 'Password changed successfully!',
			], 200);
		}else{
			return response()->json([
				'message' => 'Sorry, User not found!',
			], 401);
		}
	}
}
