<?php

use App\Http\Controllers\Web\{
    HomeController,
};

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any?}', [HomeController::class, 'spa'])->where('any', '^(?!\/)[\/\w\.-]*')->name("web-spa"); // else return SPA view
Route::get('/project-detail/{id}', [HomeController::class, 'spaProductDetail'])->name("web-spa"); // SEO for project details