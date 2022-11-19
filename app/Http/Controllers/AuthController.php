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

		try {
			$user = User::where('email', $request['email'])->firstOrFail();

			$token = $user->createToken('auth_token')->plainTextToken;

			return response()
				->json([
					'message' => 'success',
					'data' => $user,
					'access_token' => $token,
				]);
		} catch (\Throwable $e) {
			return response()
				->json([
					'message' => 'there is an unexpected error',
				], 500);
		}
	}

	public function register(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'name' => 'required|string|max:255|unique:users',
			'email' => 'required|string|email|max:255|unique:users',
			'role' => 'required|string',
			'no_phone' => 'required|string|min:12',
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
			if ($validator->errors()->first("no_phone")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("no_phone")
				], 400);
			}
			if ($validator->errors()->first("password")) {
				return response()->json([
					'message' =>
					$validator->errors()->first("password")
				], 400);
			}
		}

		try {
			$user = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'role' => $request->role,
				'no_phone' => $request->no_phone,
				'password' => Hash::make($request->password)
			]);

			return response()
				->json([
					'message' => "User created"
				], 200);
		} catch (\Throwable $e) {
			return response()
				->json([
					'message' => 'there is an unexpected error',
				], 500);
		}
	}
}
