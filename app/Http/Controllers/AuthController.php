<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
			$error = $validator->errors()->all()[0];
			return response()
				->json([
					'message' => $error
				], 401);
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

			if ($user->avatar != NULL) {
				$user->avatar = url('storage/avatar/' . $user->avatar);
			}
			return response()
				->json([
					'message' => 'success',
					'data' => $user,
					'access_token' => $token,
				]);
		} catch (Exception $e) {
			return response()
				->json([
					'message' => $e->getMessage(),
				], 500);
		}
	}

	public function register(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'username' => 'required|string|max:255|unique:users',
			'email' => 'required|string|email|max:255|unique:users',
			'role' => 'required|string',
			'no_phone' => 'required|string|min:12',
			'password' => 'required|string|min:6'
		]);

		if ($validator->fails()) {
			$error = $validator->errors()->all()[0];
			return response()
				->json([
					'message' => $error,
				], 422);
		}

		try {
			User::create([
				'username' => $request->username,
				'email' => $request->email,
				'role' => $request->role,
				'no_phone' => $request->no_phone,
				'password' => Hash::make($request->password)
			]);

			return response()
				->json([
					'message' => "User created successfully"
				], 200);
		} catch (Exception $e) {
			return response()
				->json([
					'message' => $e->getMessage(),
				], 500);
		}
	}

	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()->delete();
		return response()->json([
			'message' => "Successfully logout"
		]);
	}

	public function me(Request $request)
	{
		$user_id = $request->user()->id;
		$user = User::find($user_id);
		if ($user->avatar != NULL) {
			$user->avatar = url('storage/avatar/' . $user->avatar);
		}
		if ($user->role == "TALENT") {
			if ($user->talent) {
				$user->talent->influence;
			}
		} else {
			$user->umkm;
		}

		$user->socialMedia;
		return response()->json([
			'message' => "success",
			'data' => $user
		]);
	}

	public function update(Request $request)
	{

		try {
			$validator = Validator::make($request->all(), [
				'no_phone' => 'nullable|string|min:12',
				'avatar' => 'nullable|image',
				'address' => 'nullable|string'
			]);

			if ($validator->fails()) {
				$error = $validator->errors()->all()[0];
				return response()->json([
					'message' => $error
				], 422);
			} else {
				$user = User::find($request->user()->id);
				if ($request->no_phone) {
					$user->no_phone = $request->no_phone;
				}
				$user->address = $request->address;
				if ($request->file('avatar') && $request->avatar->isValid()) {
					if ($user->avatar != NULL) {
						Storage::disk('avatar')->delete($user->avatar);
					}

					$avatar_name = time() . '.' . $request->avatar->extension();
					$avatar_path = $request->file('avatar')->storeAs('', $avatar_name, 'avatar');
					$user->avatar = $avatar_path;
				} else if ($request->avatar == NULL) {
					if ($user->avatar != NULL) {
						Storage::disk('avatar')->delete($user->avatar);
					}
					$user->avatar = NULL;
				}
				$user->update();
				return response()
					->json([
						'message' => "User update successfully"
					], 200);
			}
		} catch (Exception $e) {
			return response()
				->json([
					'message' => $e->getMessage(),
				], 500);
		}
	}
}
