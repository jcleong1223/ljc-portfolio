<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function spa(Request $request, $any = null)
	{
		$app_name = config('app.name');
		$title = ucwords($app_name);
		$image = '/images/og.png';
		$description = "Welcome to $title.";

		$data = [
			'title' => $title,
			'image' => $image,
			'description' => $description,
			'mix_app_path' => 'applications/vue-admin-spa', // vue-demo-admin-spa or vue-admin-spa
		];

		return view('welcome-vue-admin', $data);
	}
}
