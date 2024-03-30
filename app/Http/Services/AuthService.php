<?php

namespace App\Http\Services;

use App\Exceptions\BadRequestException;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Swift_TransportException;

class AuthService
{
	public static function login(array $payload)
	{
		if (Auth::attempt($payload['credentials']))
		{
			$user = auth()->user();

			$token = $user->createToken($payload['device_name']);

			return $token;
		}

		throw new BadRequestException('The provided credentials are incorrect.');
	}

	public static function logout(array $payload)
	{
		// if(isset($payload['token'])){
		//     $cloudMessageToken = Auth::user()->userDevices()->where('token', $payload['cms_token'])->first();

		//     if($cloudMessageToken){
		//         // un-subscribe
		//         $cloudMessageToken->unsubscribeAllTopic();
		//         $cloudMessageToken->delete();
		//     }
		// }
		return auth()->user()->currentAccessToken()->delete();
	}

	public static function user()
	{
		return Auth::user();
	}

	public static function forgotPassword(String $email)
	{
		try
		{
			$result = Password::broker()->sendResetLink(['email' => $email]);
		}
		catch (Swift_TransportException $e)
		{
			Log::alert($e);
			throw new BadRequestException('Email failed to send');
		}
		return $email;
	}

	public static function resetPassword(array $request)
	{
		$result = Password::broker()->reset($request, function ($user, $password)
		{
			$user->password = Hash::make($password);
			$user->email_verified_at = now();
			$user->save();
		});

		switch ($result)
		{
			case PasswordBroker::INVALID_TOKEN:
				throw new BadRequestException('The token is invalid');
				break;
			case PasswordBroker::INVALID_USER:
				throw new BadRequestException('User is invalid');
				break;
			default:
				break;
		}

		return $result;
	}
}
