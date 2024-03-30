<?php

namespace App\Http\Controllers\Admin\Overwatch;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class OverwatchController extends Controller
{
	use AuthenticatesUsers;

	// @override
	protected function loggedOut(Request $request)
	{
		return redirect()->route('overwatch.main');
	}

	protected function redirectTo()
	{
		return route('overwatch.main');
	}

	public function username()
	{
		return 'email';
	}
}
