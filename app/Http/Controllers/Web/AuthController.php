<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\ForgotPasswordRequest;
use App\Http\Requests\Admin\Auth\LoginFormRequest;
use App\Http\Requests\Admin\Auth\ResetPasswordRequest;
use App\Http\Services\AuthService;
use App\Library\PermissionTag;
use Illuminate\Support\Facades\DB;

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

			if (!auth()->user()->hasPermissionTo(PermissionTag::PERMISSION_ACCESS_TO_VUE_WEB))
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
}
