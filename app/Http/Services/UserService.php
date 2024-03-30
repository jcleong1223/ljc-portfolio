<?php

namespace App\Http\Services;

use App\Exceptions\BadRequestException;
use App\Library\RoleTag;
use App\Models\ModelableFile;
use App\Models\User;
use App\Notifications\VerifyAccountNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Swift_TransportException;

class UserService
{
	public static function createUser(array $payload, bool $sendEmail = false): User
	{
		if (User::withTrashed()->where('email', $payload['email'])->exists())
		{
			throw new BadRequestException('Email has been taken');
		}

		$result = DB::transaction(function () use ($payload, $sendEmail)
		{
			$user = new User();

			$user = $user->create([
				'name' => $payload['name'],
				'email' => $payload['email'],
				'password' => isset($payload['password']) ? Hash::make($payload['password']) : 'p@ssw0rd',
				'email_verified_at' => $payload['email_verified_at'] ?? null,
			]);

			$user->assignRole($payload['role'] ?? RoleTag::USER);

			if ($sendEmail && $user->email)
			{
				self::sendAccountVerifyEmail($user);
			}

			return $user;
		});

		return $result;
	}

	public static function sendAccountVerifyEmail(User $user)
	{
		try
		{
			$result = Password::broker()->sendResetLink(['email' => $user->email], function ($user, $token)
			{
				$user->notify(new VerifyAccountNotification($token));
			});
		}
		catch (Swift_TransportException $e)
		{
			Log::alert($e);
			throw new BadRequestException('Email failed to send');
		}
	}

	public static function updateUser(User $user, array $payload): User
	{
		$result = DB::transaction(function () use ($user, $payload)
		{
			$user->update([
				'name' => $payload['name'] ?? $user->name,
				'email' => $payload['email'] ?? $user->email,
				'password' => $payload['password'] ?? $user->password,
			]);

			return $user;
		});

		return $result;
	}

	public static function uploadAvatar(User $user, $payload): ModelableFile
	{
		return $user->syncResizedImageFor('avatar', $payload['image'], ModelableFile::MODULE_PATH_USER_AVATAR, 800);
	}

	public static function deleteUser(User $user)
	{
		$user->restoreOrDelete();

		return $user;
	}
}
