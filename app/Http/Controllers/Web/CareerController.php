<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ParamIdFormRequest;
use App\Http\Requests\Web\Career\SendResumeRequest;
use App\Models\Career;
use App\Models\ModelableFile;
use App\Mail\ApplyCareer;
use Illuminate\Http\Request;
use App\Models\CareerApplication;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CareerController extends Controller
{
	public function home()
	{
		$careers = Career::active()->orderBy('seq_value', 'ASC')->get();

		$result = [
			'careers' => $careers,
		];

		return self::successResponse('Success', $result);
	}

	public function detail(ParamIdFormRequest $request)
	{
		$payload = $request->validated();

		$career_detail = Career::findOrFail($request->id);

		$result = [
			'career_detail' => $career_detail,
		];

		return self::successResponse('Success', $result);
	}

	public function sendResume(SendResumeRequest $request)
	{
		$payload = $request->validated();

        // $career = Career::findOrFail($payload['careerId']);
		$career = Career::where('title', $payload['position_applied'])->first();

        $result = DB::transaction(function () use ($payload, $career)
		{
			$new_career_application = CareerApplication::create([
				'career_id' => $career->id,
				'applicant_name' => $payload['name'],
                "position_applied" => $payload['position_applied'],
				"email" => $payload['email'],
                "phone" => $payload['phone'],
			]);

			$new_career_application->syncFileFor('file', $payload['resumeFile'], ModelableFile::MODULE_PATH_CAREER_RESUME_FILE, ModelableFile::FILE_TYPE_PDF);

			return $new_career_application;
		});

		//return self::successResponse('Success', $result);

        $filePath = storage_path("uploads/career-resume-file/{$result->id}/{$result->file->name}");

        $data = [
            "name" => $payload['name'],
            "email" => $payload['email'],
            "phone_num" => $payload['phone'],
            "apply_position" => $payload['position_applied'],
            "resume_file" => $payload['resumeFile'],
            "attachment" => $filePath,
        ];

        // $file = storage_path('uploads/career-resume-file/23/9bd7626d-cd4c-4909-8224-40f0493fa2c2.pdf');

        Mail::to(config('app.contact_us.receiver_email'))->send(new ApplyCareer($data, $career));

        return self::successResponse(__('message.submitted_success'), $data);
    }
}
