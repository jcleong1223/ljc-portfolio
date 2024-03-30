<?php

use App\Http\Controllers\Admin\{
	AdminController,
	AuthController,
	BannerController,
	CareerController,
	CertificateController,
	CkeditorAssetController,
	ClientController,
	DashboardController,
	FabricationController,
	GeneralSettingController,
	ProductCategoryController,
	ProductController,
	PublicFileController,
	ServiceController,
	UserController,
};
use Illuminate\Support\Facades\Route;

Route::prefix('api')->middleware([])->group(function ()
{
	Route::prefix('auth')->group(function ()
	{
		Route::post('/login', [AuthController::class, 'login']);
		Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
	});
});

// sanctum auth
Route::prefix('api')->middleware(['auth:sanctum'])->group(function ()
{
	Route::prefix('admin')->middleware(['can:access-to-admin-panel'])->group(function ()
	{
		Route::get('/list', [AdminController::class, 'list']);
		Route::get('/info/{id}', [AdminController::class, 'info']);
		Route::post('/create', [AdminController::class, 'create']);
		Route::put('/update', [AdminController::class, 'update']);
		Route::delete('/archive', [AdminController::class, 'delete']);
		Route::put('/update-password', [AdminController::class, 'adminPasswordUpdate']);
		Route::post('/email-reset-password', [AdminController::class, 'emailResetPassword']);
		Route::post('/verification/send', [AdminController::class, 'resendVerificationEmail']);
		Route::post('/verification/toggle', [AdminController::class, 'toggleVerificationStatus']);
	});

	Route::prefix('auth')->group(function ()
	{
		Route::get('/user', [AuthController::class, 'user']);
		Route::put('/update', [AuthController::class, 'authUpdate']);
		Route::put('/edit-password', [AuthController::class, 'authUpdatePassword']);
		Route::post('/upload-avatar', [AuthController::class, 'uploadAvatar']);
		Route::delete('/logout', [AuthController::class, 'logout']);
	});

	Route::prefix('banner')->group(function ()
	{
		Route::get('/list', [BannerController::class, 'list']);
		Route::post('/create', [BannerController::class, 'create']);
		Route::post('/update', [BannerController::class, 'update']);
		Route::delete('/archive', [BannerController::class, 'delete']);
	});

	Route::prefix('dashboard')->group(function ()
	{
		Route::get('/', [DashboardController::class, 'getDashboard']);
	});

	Route::prefix('general-setting')->group(function ()
	{
		Route::get('/index', [GeneralSettingController::class, 'index']);
		Route::put('/update', [GeneralSettingController::class, 'update']);
	});

	Route::prefix('public-file')->group(function ()
	{
		Route::post('/upload/{path_type}', [PublicFileController::class, 'upload']);
	});

	Route::prefix('user')->group(function ()
	{
		Route::get('/list', [UserController::class, 'list']);
		Route::get('/info/{id}', [UserController::class, 'info']);
		Route::post('/create', [UserController::class, 'create']);
		Route::put('/update', [UserController::class, 'update']);
		Route::delete('/archive', [UserController::class, 'delete']);
		Route::put('/update-password', [UserController::class, 'userPasswordUpdate']);
		Route::post('/email-reset-password', [UserController::class, 'emailResetPassword']);
		Route::post('/verification/send', [UserController::class, 'resendVerificationEmail']);
		Route::post('/verification/toggle', [UserController::class, 'toggleVerificationStatus']);
	});

	Route::prefix('product')->group(function ()
	{
		Route::get('/list', [ProductController::class, 'list']);
		Route::get('/info/{id}', [ProductController::class, 'info']);
		Route::post('/create', [ProductController::class, 'create']);
		Route::post('/update', [ProductController::class, 'update']);
		Route::delete('/archive', [ProductController::class, 'delete']);
	});

	Route::prefix('career')->group(function ()
	{
		Route::get('/list', [CareerController::class, 'list']);
		Route::get('/info/{id}', [CareerController::class, 'info']);
		Route::post('/create', [CareerController::class, 'create']);
		Route::post('/update', [CareerController::class, 'update']);
		Route::delete('/archive', [CareerController::class, 'delete']);
	});

	Route::prefix('certificate')->group(function ()
	{
		Route::get('/list', [CertificateController::class, 'list']);
		Route::post('/create', [CertificateController::class, 'create']);
		Route::post('/update', [CertificateController::class, 'update']);
		Route::delete('/archive', [CertificateController::class, 'delete']);
	});

	Route::prefix('client')->group(function ()
	{
		Route::get('/list', [ClientController::class, 'list']);
		Route::post('/create', [ClientController::class, 'create']);
		Route::post('/update', [ClientController::class, 'update']);
		Route::delete('/archive', [ClientController::class, 'delete']);
	});

	Route::prefix('fabrication')->group(function ()
	{
		Route::get('/list', [FabricationController::class, 'list']);
		Route::post('/create', [FabricationController::class, 'create']);
		Route::post('/update', [FabricationController::class, 'update']);
		Route::delete('/archive', [FabricationController::class, 'delete']);
	});

	Route::prefix('service')->group(function ()
	{
		Route::get('/list', [ServiceController::class, 'list']);
		Route::get('/info/{id}', [ServiceController::class, 'info']);
		Route::post('/create', [ServiceController::class, 'create']);
		Route::post('/update', [ServiceController::class, 'update']);
		Route::delete('/archive', [ServiceController::class, 'delete']);
	});

	Route::prefix('product-category')->group(function ()
	{
		Route::get('/list', [ProductCategoryController::class, 'list']);
		Route::get('/info/{id}', [ProductCategoryController::class, 'info']);
		Route::post('/create', [ProductCategoryController::class, 'create']);
		Route::put('/update', [ProductCategoryController::class, 'update']);
		Route::delete('/archive', [ProductCategoryController::class, 'delete']);
	});
});
