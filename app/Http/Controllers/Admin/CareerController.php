<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Career\CreateCareerFormRequest;
use App\Http\Requests\Admin\Career\ListFormRequest as CareerListFormRequest;
use App\Http\Requests\Admin\Career\UpdateCareerFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Http\Requests\ParamIdFormRequest;
use App\Models\Career;
use App\Queriplex\CareerQueriplex;
use Illuminate\Support\Facades\DB;

class CareerController extends Controller
{
	public function list(CareerListFormRequest $request)
	{
		$payload = $request->validated();

		$result = CareerQueriplex::make(Career::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		return self::successResponse('Success', $result);
	}

	public function info(ParamIdFormRequest $request)
	{
		$payload = $request->validated();

		$result = CareerQueriplex::make(Career::query(), $payload)
				->withTrashed()
				->firstOrThrowError();

		return self::successResponse('Success', $result);
	}

	public function create(CreateCareerFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$career = Career::create([
				'title' => $payload['title'],
				'location' => $payload['location'],
				'description' => $payload['description'],
				'salary_range' => $payload['salary_range'],
				'exp_required' => $payload['exp_required'],
				'type' => $payload['type'],
				'status' => $payload['status'],
				'seq_value' => $payload['seq_value'],
				'career_level' => $payload['career_level'],
				'specializations' => $payload['specializations'],
				'qualifications' => $payload['qualifications'],
			]);

			return $career;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateCareerFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$career = Career::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$career->update([
				'title' => $payload['title'],
				'location' => $payload['location'],
				'description' => $payload['description'],
				'salary_range' => $payload['salary_range'],
				'exp_required' => $payload['exp_required'],
				'type' => $payload['type'],
				'status' => $payload['status'],
				'seq_value' => $payload['seq_value'],
				'career_level' => $payload['career_level'],
				'specializations' => $payload['specializations'],
				'qualifications' => $payload['qualifications'],
			]);

			return $career;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = Career::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}
}
