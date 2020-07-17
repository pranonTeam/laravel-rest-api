<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
	/**
	 * Handle a login request to the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function login(Request $request) {
		$request->validate([
			'email' => 'required',
			'password' => 'required',
		]);

		try {
			if (Auth::attempt($request->only('email', 'password'))) {
				return $this->createAccessToken(auth()->user());
			}

			return respondError(UNAUTHORIZED, 401);
		} catch (\Exception $e) {
			return respondError($e->getMessage());
		}
	}

	/**
	 * Create auth user access token
	 * @param  Object $user
	 * @return Token
	 */
	protected function createAccessToken($user) {
		if ($token = $user->createToken('Plasma Bank Password Grant Client')->accessToken) {
			return (new UserResource($user))->additional([
				'token' => $token,
			]);
		}

		throw new \Exception('Failed to create generate token!');
	}
}
