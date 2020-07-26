<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Code;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
	/**
	 * Create user
	 */
	public function signup(Request $request)
	{
		$validated = Validator::make($request->all(), [
			'name' => 'required',
			'balance' => 'nullable',
			'email' => 'required|string|email|unique:users',
			'password' => 'required|string|min:8|confirmed'
		]);
		if ($validated->fails()) {
			return response()->json($validated->messages(), 401);
		}
		$url = "http://localhost:5000";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result=curl_exec($ch);
		$result = json_decode($result, true);
		$user = new User($request->all());
		$user->score = $result['score'];
		if ($user->admin == 2)
			$user->admin = 0;
		$user->password = Hash::make($user->password);
		$user->save();
		return response()->json([
			'message' => 'Successfully created user!'
		], 201);
	}

	/**
	 * Login user and create token
	 *
	 * @param  [string] email
	 * @param  [string] password
	 * @param  [boolean] remember_me
	 * @return [string] access_token
	 * @return [string] token_type
	 * @return [string] expires_at
	 */
	public function login(Request $request)
	{
		$request->validate([
			'email' => 'required|string|email',
			'password' => 'required|string',
			'remember_me' => 'boolean'
		]);
		$credentials = [
			'email' => request()->input('email'),
			'password' => request()->input('password'),
		];
		// $credentials['password'] = $this->run(substr($credentials['password'], 20, strlen($credentials['password']) - 40), -5);
		$user = User::where(['email' => $credentials['email']]);
		if ($user->count() == 0)
			return response()->json([
				'error' => 'Email doesn\'t exist'
			], 401);

		$user = $user->first();


		if (!Hash::check($credentials['password'], $user->password))
			return response()->json([
				'error' => 'Email/Password combination incorrect'
			], 401);
		$tokenResult = $user->createToken('Personal Access Token');
		$token = $tokenResult->token;
		if ($request->remember_me)
			$token->expires_at = Carbon::now()->addWeeks(56);
		$token->save();
		return response()->json([
			'access_token' => $tokenResult->accessToken,
			'token_type' => 'Bearer',
			'expires_at' => Carbon::parse(
				$tokenResult->token->expires_at
			)->toDateTimeString()
		]);
	}

	/**
	 * Logout user (Revoke the token)
	 *
	 * @return [string] message
	 */
	public function logout(Request $request)
	{
		$request->user()->token()->revoke();
		return response()->json([
			'message' => 'Successfully logged out'
		]);
	}

	/**
	 * Get the authenticated User
	 *
	 * @return [json] user object
	 */
	public function user(Request $request)
	{
		$user = Auth::user();
		return response()->json($user);
	}

	/**
	 * 
	 * Update user
	 * 
	 */

	public function updateUser(Request $request, User $user)
	{
		$validatedData = $request->validate([
			'name' => 'nullable',
			'balance' => 'nullable',
			'email' => 'nullable|string|email|unique:users',
		]);
		$user->update(array_filter($validatedData));
		$user->save();
		return $user;
	}

	public function checkPassword(Request $request)
	{
		// $validatedData = $request->validate([
		//     'password'=>'required'
		// ]);
		$v = Hash::check($request->input('password'), Auth::user()->password);
		return response()->json([
			'check' => $v
		]);
	}

	public function updatePassword(Request $request)
	{
		$validatedData = $request->validate([
			'old_password' => 'required',
			'password' => 'required|min:8|confirmed',
		]);
		if (Hash::check($validatedData['old_password'], Auth::user()->password)) {
			$user = User::find(Auth::user()->id);
			$user->password = Hash::make($validatedData['password']);
			$user->save();
			return response()->json(['success' => 'Password updated with success']);
		}
		return response()->json(['error' => 'Wrong password'], 401);
	}

	public function resetPassword(Request $request)
	{
		$user = User::where(['email' => $request->input('email')])->first();
		if ($user == null) {
			return response()->json(['error' => 'Email doesn\'t exist'], 400);
		}
		$s = sha1(time());
		$pw_reset = DB::table('password_resets')->insert(
			['token' => $s, 'email' => $request->input('email')]
		);
		$user->sendPasswordResetNotification($s);
		// DB::table('password_resets')->where('email', $user->email)->first();
		return response()->json(['success' => "Password reset email sent"]);
	}

	public function setPassword(Request $request)
	{
		$user = User::where(['email' => $request->input('email')])->first();
		$pw_reset = DB::table('password_resets')->where(
			['token' => $request->input('token'), 'email' => $user->email]
		);
		if ($pw_reset->count() > 0) {
			$user->password = Hash::make($request->input('password'));
			$user->save();
			$pw_reset->delete();
			return response()->json(['success' => "Password changed"]);
		}
		return response()->json(['error' => 'invalid token/email'], 400);
		// DB::table('password_resets')->where('email', $user->email)->first();
	}
}
