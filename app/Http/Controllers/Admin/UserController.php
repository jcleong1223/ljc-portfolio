<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateFormRequest;
use App\Http\Requests\Admin\User\ListFormRequest;
use App\Http\Requests\Admin\User\PasswordUpdateFormRequest;
use App\Http\Requests\Admin\User\UpdateFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Http\Requests\ParamIdFormRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;
use App\Library\RoleTag;
use App\Models\User;
use App\Queriplex\UserQueriplex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	public function list(ListFormRequest $request)
	{
		$payload = $request->validated();
		$payload['roles'] = RoleTag::getNonAdminRoles();

		$users = UserQueriplex::make(User::query(), $payload);

		$result = $users->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'roles',
			'avatar',
		]);

		return self::successResponse('Success', $result);
	}

	public function info(ParamIdFormRequest $request)
	{
		$payload = $request->validated();

		$result = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result->load([
			'tokens',
			'roles',
			'avatar',
		]);

		return self::successResponse('Success', $result);
	}

	public function create(CreateFormRequest $request)
	{
		$payload = $request->validated();

		$payload['email_verified_at'] = now();
		$result = UserService::createUser($payload, $payload['send_email'] ?? false);

		return self::successResponse('Success', $result);
	}

	public function update(UpdateFormRequest $request)
	{
		$payload = $request->validated();

		$user = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = UserService::updateUser($user, $payload);

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$user = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = UserService::deleteUser($user);

		return self::successResponse('Success', $result);
	}

	public function userPasswordUpdate(PasswordUpdateFormRequest $request)
	{
		$payload = $request->validated();

		$user = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$user->password = Hash::make($request['password']);
		$user->save();

		return self::successResponse('Success', true);
	}

	public function emailResetPassword(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
		]);

		$user = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = AuthService::forgotPassword($user->email);

		return self::successResponse('Email Sent', $result);
	}

	public function resendVerificationEmail(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
		]);
		$user = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		UserService::sendAccountVerifyEmail($user);

		return self::successResponse('Success', true);
	}

	public function toggleVerificationStatus(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
		]);
		$user = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$user->update([
			'email_verified_at' => $user->email_verified_at ? null : now(),
		]);

		return self::successResponse('Success', $user);
	}
}
