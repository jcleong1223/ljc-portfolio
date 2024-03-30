<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ContactUs\SendEmailRequest;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
	public function sendEmail(SendEmailRequest $request)
	{
		$payload = $request->validated();

		$data = [
			'name'=> $payload['name'],
			'email' =>  $payload['email'],
			// 'phone_num' =>  $payload['phone_prefix'] . '-' . $payload['phone'],
			'phone_num' =>  $payload['phone'],
			'message' =>  $payload['message'],
			'subject' => $payload['subject'],
		];

		Mail::to(config('app.contact_us.receiver_email'))->send(new ContactUs($data));

		return self::successResponse(__('message.submitted_success'), $data);
	}
}
