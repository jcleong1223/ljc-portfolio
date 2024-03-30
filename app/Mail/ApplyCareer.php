<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class ApplyCareer extends Mailable
{
	use Queueable;
	use SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($data, $career)
	{
		$this->data = $data;
		$this->career = $career;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->subject('New Job Application')
			->markdown('mail.sendresume')
			->with('data', $this->data)
			->with('career', $this->career)
			->attach($this->data['attachment']);
	}

	// public function attachment(): array
	// {
	// 	return [
	// 		Attachment::fromPath($this->data['attachment'])->withMime('application/pdf')
	// 	];
	// }

}
