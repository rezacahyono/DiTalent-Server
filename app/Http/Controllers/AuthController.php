<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
	public function login(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'email' => 'required|string',
			'password' => 'required|string|min:6'
		]);

		if ($validator->fails()) {
			if ($validator->errors()->first("email")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("email")
				], 400);
			}
			if ($validator->errors()->first("password")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("password")
				], 400);
			}
		}

		if (!Auth::attempt($request->only('email', 'password'))) {
			return response()
				->json([
					'message' => 'the credential is not found'
				], 401);
		}

		$user = User::where('email', $request['email'])->firstOrFail();

		$token = $user->createToken('auth_token')->plainTextToken;

		return response()
			->json([
				'data' => $user,
				'access_token' => $token,
			]);
	}

	public function register(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255|unique:users',
			'email' => 'required|string|email|max:255|unique:users',
			'role' => 'required|string',
			'password' => 'required|string|min:6'
		]);

		if ($validator->fails()) {
			if ($validator->errors()->first("email")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("email")
				], 400);
			}
			if ($validator->errors()->first("name")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("name")
				], 400);
			}
			if ($validator->errors()->first("role")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("role")
				], 400);
			}
			if ($validator->errors()->first("password")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("password")
				], 400);
			}
		}

		$user = User::create([
			'name' => $request->name,
			'email' => $request->email,
			'role' => $request->role,
			'password' => Hash::make($request->password)
		]);

		if (!is_null($user)) {
			return response()
				->json([
					'message' => "User created"
				]);
		} else {
			return response()
				->json([
					'message' => "Failed created user"
				]);
		}
	}
}
