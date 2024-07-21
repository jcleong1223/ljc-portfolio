<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Client;
use App\Models\PortfolioProject;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\ParamIdFormRequest;

class HomeController extends Controller
{
	public function spa(Request $request, $any = null)
	{
		$app_name = config('app.name');
		$title = ucwords($app_name);
		$image = '/images/og.png';
		$description = "Welcome to $title.";

		// if($any == "project-detail/6")
		// {
		// 	$title = "Coffee Brand";
		// }

		$data = [
			'title' => $title,
			'image' => $image,
			'description' => $description,
			'mix_app_path' => 'applications/vue-web-spa', // vue-demo-web-spa or vue-web-spa
		];

		return view('welcome-vue-web', $data);
	}

	public function homePortfolio()
	{
		$projects = PortfolioProject::where('status', 1)
					->with([
						'image',
						'tags'
						// 'mediaContents.content',
					])
					// ->orderBy('created_at', 'desc')
					->orderBy('seq_value', 'DESC')
					->get();

		$result = [
			'projects' => $projects,
		];

		return self::successResponse('Success', $result);
	}

	public function homePortfolioInfo(ParamIdFormRequest $request)
	{
		$payload = $request->validated();

		$project = PortfolioProject::with([
			'image',
			'tags',
			'mediaContents.content',
		])
		->find($payload['id']);

		$result = [
			'project' => $project,
		];

		return self::successResponse('Success', $result);
	}

	public function home()
	{
		$banners = Banner::orderBy('seq_value', 'ASC')
			->with([
				'image',
				'webImage',
				'mobileImage',
			])
			->get();

		$capabilities = Service::where('status', 1)->orderBy('seq_value', 'ASC')->get();
		$capabilities->load([
			'image',
			'mediaContents.content',
		]);

		$clients = Client::where('status', 1)->orderBy('seq_value', 'ASC')
			->with([
				'image',
				'webImage',
			])->get();

		$result = [
			'banners' => $banners,
			'capabilities' => $capabilities,
			'clients' => $clients,
		];

		return self::successResponse('Success', $result);
	}

	public function spaProductDetail()
	{
		
	}
}
