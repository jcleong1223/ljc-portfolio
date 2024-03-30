<?php

namespace Pylon\Exceptions;

use Exception;

class BadRequestException extends Exception
{
	/**
	 * The additional data of the error.
	 *
	 * @var any
	 */
	public $value = null;

	/**
	 * The mechanized code in describing the error type.
	 *
	 * @var int
	 */
	public $error_code = 40000;

	/**
	 * The mechanized text in describing the error type.
	 *
	 * @var string
	 */
	public $error_text = 'ERROR';

	/**
	 * Create a new exception instance.
	 *
	 * @param string $message
	 * @param int    $status
	 *
	 * @return void
	 */
	public function __construct($message, $status = 400)
	{
		$this->message = $message;
		$this->status = $status;
	}

	/**
	 * Report the exception.
	 *
	 * @return bool|null
	 */
	public function report()
	{
		return true;
	}

	/**
	 * Render the exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function render($request)
	{
		if ($request->expectsJson())
		{
			return $this->setJsonResponse();
		}

		return redirect()->back()
			->withInput()
			->withErrors($this->getMessage());
	}

	/**
	 * Set the additional data to be used for the response.
	 *
	 * @param mixed $value
	 *
	 * @return $this
	 */
	public function withValue($value)
	{
		$this->value = $value;

		return $this;
	}

	/**
	 * Set the error type to be used for the response.
	 *
	 * @param int $status
	 *
	 * @return $this
	 */
	public function withErrorKey(int $errorCode, String $errorText = 'Error')
	{
		$this->error_code = $errorCode;
		$this->error_text = $errorText;

		return $this;
	}

	/**
	 * Render the HTTP response in JSON form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function setJsonResponse()
	{
		$response = [
			'message' => $this->getMessage(),
			'code'   => $this->error_code,
			'error_text'   => $this->error_text,
		];

		if ($this->value)
		{
			$response['value'] = $this->value;
		}

		return response()->json($response, $this->status);
	}
}
