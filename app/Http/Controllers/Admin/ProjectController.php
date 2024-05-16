<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Project\CreateProjectFormRequest;
use App\Http\Requests\Admin\Project\ListFormRequest;
use App\Http\Requests\Admin\Project\UpdateProjectFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Http\Services\CapabilityService;
use App\Models\PortfolioProject;
use App\Models\ModelableFile;
use App\Models\ProjectTag;
use App\Models\Tag;
use App\Queriplex\ProjectQueriplex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    //

    public function list(ListFormRequest $request)
    {
        $payload = $request->validated();

		$result = ProjectQueriplex::make(PortfolioProject::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

		$result->load([
			'webImage',
			'tags',
		]);
		return self::successResponse('Success', $result);
    }

	public function create(CreateProjectFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$project = PortfolioProject::create([
				'title' => $payload['title'],
				'short_description' => $payload['short_description'],
				'description' => $payload['description'],
				'status' => $payload['status'],
				'seq_value' => $payload['seq_value'],
			]);
			$project->syncResizedImageFor('image', $payload['image'], ModelableFile::MODULE_PATH_PORTFOLIO_IMAGE, 2000);
			// CapabilityService::syncGalleries($project, $payload['media_contents'] ?? []);

			foreach($payload['tags'] as $tag){
				$project->tags()->attach($tag);
			}

			return $project;
		});

		return self::successResponse('Success', $result);
	}

	public function update(UpdateProjectFormRequest $request)
	{
		$payload = $request->validated();

		$result = DB::transaction(function () use ($payload)
		{
			$project = PortfolioProject::where('id', $payload['id'])
						->withTrashed()
						->firstOrThrowError();
						// dd($payload['tags']);
			$project->update([
				'title' => $payload['title'],
				'short_description' => $payload['short_description'],
				'description' => $payload['description'],
				'status' => $payload['status'],
				'seq_value' => $payload['seq_value'],
			]);

			if (!empty($payload['tags'])) {
				$project->tags()->sync($payload['tags']);
			} else {
				$project->tags()->detach();
			}

			return $project;
		});

		return self::successResponse('Success', $result);
	}

	public function delete(IdOnlyFormRequest $request)
	{
		$payload = $request->validated();

		$object = PortfolioProject::where('id', $payload['id'])
			->withTrashed()
			->firstOrThrowError();

		$result = $object->restoreOrDelete();

		return self::successResponse('Success', $result);
	}

	public function getTagList(ListFormRequest $request)
	{
		$payload = $request->validated();

		$tags = Tag::where('status', 1)->get();

		return self::successResponse('Success', $tags);
	}
}
