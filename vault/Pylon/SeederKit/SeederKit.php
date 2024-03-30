<?php

namespace Pylon\SeederKit;

use Closure;
use Maatwebsite\Excel\Facades\Excel;
use Pylon\SeederHelper\Readers\GeneralExcelReader;

class SeederKit
{
	public static function fromCSV(string $filePath, Closure $callback): void
	{
		Excel::import(new GeneralExcelReader($callback), $filePath);

		return;
	}

	public static function fromJson(string $filePath, Closure $callback): void
	{
		$dataList = collect(json_decode(file_get_contents($filePath), true));
		$callback($dataList);

		return;
	}
}
