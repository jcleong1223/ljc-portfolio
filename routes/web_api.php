<?php

use App\Http\Controllers\Web\{
	AuthController,
	CapabilityController,
	CareerController,
	CertificateController,
	ContactUsController,
	FabricationController,
	HomeController,
};
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware([])->group(function ()
{
	Route::prefix('auth')->group(function ()
	{
		Route::post('/login', [AuthController::class, 'login']);
		Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
		Route::post('/reset-password', [AuthController::class, 'resetPassword']);
	});

	Route::prefix('base')->group(function ()
	{
		Route::get('/home', [HomeController::class, 'home']);
		Route::post('/contact-us', [ContactUsController::class, 'sendEmail']);
		Route::get('/capabilities', [CapabilityController::class, 'home']);
		Route::get('/capabilities/{id}', [CapabilityController::class, 'info']);
		Route::get('/careers', [CareerController::class, 'home']);
		Route::get('/career-detail/{id}', [CareerController::class, 'detail']);
		Route::post('/career-application', [CareerController::class, 'sendResume']);
		Route::get('/fabrications', [FabricationController::class, 'home']);
		Route::get('/fabrications/{page}', [FabricationController::class, 'getPaginateData']);
		Route::get('/certificates', [CertificateController::class, 'home']);
	});
});

Route::prefix('api')->middleware(['auth:sanctum'])->group(function ()
{
	// Route::prefix('auth')->group(function ()
	// {
	// 	Route::get('/user', [AuthController::class, 'user']);
	// 	Route::delete('/logout', [AuthController::class, 'logout']);
	// });
});
