<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AuthPasswordUpdateFormRequest;
use App\Http\Requests\Admin\Auth\AuthProfileUpdateFormRequest;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\Admin\Auth\LoginFormRequest;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use App\Http\Requests\Admin\Auth\UploadAvatarFormRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;
use App\Library\PermissionTag;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	public function login(LoginFormRequest $request)
	{
		$payload = $request->validated();

		$payload['credentials'] = [
			'email' => $payload['email'],
			'password' => $payload['password'],
		];

		return DB::transaction(function () use ($payload)
		{
			$token = AuthService::login($payload);

			if (!auth()->user()->hasPermissionTo(PermissionTag::PERMISSION_ACCESS_TO_ADMIN_PANEL))
			{
				throw new BadRequestException('Your Access Permission is Unauthorized', 403);
			}

			return self::successResponse('Success', [
				'token' => $token->plainTextToken,
				'user' => auth()->user(),
			])->header('Authorization', $token->plainTextToken);
		});
	}

	public function logout()
	{
		$result = AuthService::logout([]);

		return self::successResponse('Success', $result);
	}

	public function authUpdate(AuthProfileUpdateFormRequest $request)
	{
		$payload = $request->validated();

		$authUser = auth()->user();

		$result = UserService::updateUser($authUser, $payload);

		return self::successResponse('Success', $result);
	}

	public function user()
	{
		$authUser = auth()->user();

		$authUser->load([
			'avatar',
			'roles',
		]);

		$authUser['all_permissions'] = $authUser->getAllPermissions()->map(function ($item)
		{
			return $item->name;
		});

		return self::successResponse('Success', [
			'user' => $authUser,
		]);
	}

	public function updatePassword(AuthPasswordUpdateFormRequest $request)
	{
		$payload = $request->validated();

		$authUser = auth()->user();

		// check current password
		if (!Hash::check($request['current_password'], $authUser->password))
		{
			throw new BadRequestException('Current Password is invalid.');
		}

		// see if old and new password are equal
		if (Hash::check($request['password'], $authUser->password))
		{
			throw new BadRequestException('New password cannot be the same as current password.');
		}

		$result = UserService::updateUser($authUser, [
			'password' => Hash::make($payload['password']),
		]);

		return self::successResponse('Success', [
			'status' => ($result != null),
		]);
	}

	public function forgotPassword(ForgotPasswordRequest $request)
	{
		$payload = $request->validated();

		$result = AuthService::forgotPassword($payload['email']);

		return self::successResponse('Success', [
			'email' => $result,
		]);
	}

	public function resetPassword(ResetPasswordRequest $request)
	{
		$result = AuthService::resetPassword($request->validated());

		return self::successResponse('Success', $result);
	}

	public function uploadAvatar(UploadAvatarFormRequest $request)
	{
		$payload = $request->validated();

		$authUser = auth()->user();

		$result = UserService::uploadAvatar($authUser, $payload);

		return self::successResponse('Success', $result);
	}
}
