<?php

namespace Pylon\SeederHelper\Readers;

use Closure;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GeneralExcelReader implements ToCollection, WithHeadingRow
{
	public Closure $callback;

	public function __construct(Closure $callback)
	{
		$this->callback = $callback;
	}

	public function collection(Collection $rows)
	{
		$callback = $this->callback;
		$callback($rows);
	}
}
