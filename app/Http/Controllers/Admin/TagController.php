<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tag\CreateTagFormRequest;
use App\Http\Requests\Admin\Tag\ListFormRequest;
use App\Http\Requests\Admin\Tag\UpdateTagFormRequest;
use App\Http\Requests\IdOnlyFormRequest;
use App\Models\ModelableFile;
use App\Models\Tag;
use App\Queriplex\TagQueriplex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    //
    public function list(ListFormRequest $request)
    {
        $payload = $request->validated();

        $result = TagQueriplex::make(Tag::query(), $payload)
					->paginate($payload['itemsPerPage'] ?? 15);

        $result->load([
            'webImage',
        ]);

		return self::successResponse('Success', $result);
    }

    public function create(CreateTagFormRequest $request)
    {

        $payload = $request->validated();

        $result = DB::transaction(function () use ($payload) {
            $tag = Tag::create([
                'title' => $payload['title'],
                'level' => $payload['level'],
                'status' => $payload['status'],
                'seq_value' => $payload['seq_value']
            ]);

            $tag->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_TAG_WEB_IMAGE, 2000);

            return $tag;
        });

        return self::successResponse('Success', $result);
    }

    public function update(UpdateTagFormRequest $request)
    {
        $payload = $request->validated();
// dd($payload);
        $result = DB::transaction(function () use ($payload)
		{
			$tag = Tag::where('id', $payload['id'])
				->withTrashed()
				->firstOrThrowError();

			$tag->update([
				'title' => $payload['title'],
                'level' => $payload['level'],
				'seq_value' => $payload['seq_value'],
				'status' => $payload['status'],
			]);

			$tag->syncResizedImageFor('webImage', $payload['web_image'], ModelableFile::MODULE_PATH_TAG_WEB_IMAGE, 2000);

			return $tag;
		});

		return self::successResponse('Success', $result);
    }

    public function delete(IdOnlyFormRequest $request)
    {
        $payload = $request->validated();

        $object = Tag::where('id', $payload['id'])
            ->withTrashed()
            ->firstOrThrowError();

        $result = $object->restoreOrDelete();

        return self::successResponse('Success', $result);
    }

}
