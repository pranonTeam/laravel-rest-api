<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller {
	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function createUser(Request $request) {

		$validator = \Validator::make($request->all(), [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'password' => ['required', 'string', 'min:6'],
		]);

		if ($validator->fails()) {
			$failedRules = $validator->failed();

			if (isset($failedRules['email']['Unique'])) {
				return respondError('Email Already Taken');
			}

			return respondError('Parameters failed validation');
		}

		try {
			event(new Registered($user = $this->create($request->all())));

			if ($user) {
				return $this->createAccessToken($user);
			}

			return respondError(FAIL);
		} catch (\Exception $e) {
			return respondError($e->getMessage());
			return respondError('Failed to register!');
		}
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return \App\Models\User
	 */
	protected function create(array $data) {
		return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
		]);
	}

	/**
	 * Create auth user access token
	 * @param  Object $user
	 * @return Token
	 */
	protected function createAccessToken($user) {
		if ($token = $user->createToken('PlasmaBank Personal Access Client')->accessToken) {
			return (new UserResource($user))->additional([
				'token' => $token,
			]);
		}

		throw new \Exception('Failed to create generate token!');
	}
}
