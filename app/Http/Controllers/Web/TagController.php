<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function home()
    {
        $mySkillTags = Tag::where('status', 1)->where('my_skill', 1)->orderBy('created_at', 'ASC')
		->with([
			'webImage',
		])
		->get();

		$result = [
			'my_skills' => $mySkillTags,
		];

		return self::successResponse('Success', $result);
    }
}
