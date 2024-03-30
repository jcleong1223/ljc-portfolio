<?php

namespace App\Exceptions;

use App\Library\ResponseCode;
use Pylon\Exceptions\BadRequestException as BaseException;

class BadRequestException extends BaseException
{
	// @override
	public $error_code = ResponseCode::DEFAULT_ERROR;

	public static function invalidPermissionError($message = 'Invalid Permission')
	{
		return new static($message);
	}

	public static function invalidOwnershipError($message = 'Invalid Ownership')
	{
		return new static($message);
	}
}
