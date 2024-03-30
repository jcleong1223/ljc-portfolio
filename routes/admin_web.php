<?php

use App\Http\Controllers\Admin\{
    HomeController,
	Overwatch\OverwatchController,
};
use Illuminate\Support\Facades\Route;

Route::prefix('overwatch')->name('overwatch.')->group(function ()
{
	Route::middleware(['guest'])->group(function () {
		Route::get('/', [OverwatchController::class, 'showLoginForm'])->name('main');
		Route::post('/login', [OverwatchController::class, 'login'])->name('login');
	});

	Route::middleware(['auth'])->group(function () {
		Route::view('/home', 'overwatch-home')->name('home');
		Route::post('/logout', [OverwatchController::class, 'logout'])->name('logout');
	});
});

Route::get('/{any?}', [HomeController::class, 'spa'])->where('any', '^(?!\/)[\/\w\.-]*')->name("admin-spa"); // else return SPA view
