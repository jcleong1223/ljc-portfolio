<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\CreateFormRequest;
use App\Http\Requests\Admin\Admin\ListFormRequest;
use App\Http\Requests\Admin\Admin\PasswordUpdateFormRequest;
use App\Http\Requests\Admin\Admin\UpdateFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Http\Requests\ParamIdFormRequest;
use App\Http\Services\AuthService;
use App\Http\Services\UserService;
use App\Library\RoleTag;
use App\Models\User;
use App\Queriplex\UserQueriplex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
	public function list(ListFormRequest $request)
	{
		$payload = $request->validated();
		$payload['roles'] = RoleTag::getAdminOnlyRoles();

		$admins = UserQueriplex::make(User::query(), $payload);

		$result = $admins->paginate($payload['itemsPerPage'] ?? 15);

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
		$payload['role'] = RoleTag::ADMIN;
		$result = UserService::createUser($payload, $payload['send_email'] ?? false);

		return self::successResponse('Success', $result);
	}

	public function update(UpdateFormRequest $request)
	{
		$payload = $request->validated();

		$admin = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = UserService::updateUser($admin, $payload);

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$admin = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = UserService::deleteUser($admin);

		return self::successResponse('Success', $result);
	}

	public function adminPasswordUpdate(PasswordUpdateFormRequest $request)
	{
		$payload = $request->validated();

		$admin = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$admin->password = Hash::make($request['password']);
		$admin->save();

		return self::successResponse('Success', true);
	}

	public function emailResetPassword(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
		]);

		$admin = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = AuthService::forgotPassword($admin->email);

		return self::successResponse('Email Sent', $result);
	}

	public function resendVerificationEmail(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
		]);
		$admin = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		UserService::sendAccountVerifyEmail($admin);

		return self::successResponse('Success', true);
	}

	public function toggleVerificationStatus(Request $request)
	{
		$payload = $request->validate([
			'id' => ['required'],
		]);
		$admin = User::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$admin->update([
			'email_verified_at' => $admin->email_verified_at ? null : now(),
		]);

		return self::successResponse('Success', $admin);
	}
}
