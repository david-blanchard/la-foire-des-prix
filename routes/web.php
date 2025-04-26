<?php

use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProductInfoController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
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

/**
 * Application routes
 */
Route::get('/mode-femme', [ProductInfoController::class, 'index'])->name('default');
Route::get('/mode-femme/{slug}', [ProductInfoController::class, 'show'])->name('product');
Route::get('/recherche/{slug}', [ProductInfoController::class, 'show'])->name('search');
Route::redirect('/', '/mode-femme', 301)->name('root');
Route::redirect('/home', '/mode-femme', 301)->name('home');

/**
 * Session routes
 */
Route::post('/session/store', [SessionController::class, 'store'])->name('session.store');
Route::post('/session/retrieve', [SessionController::class, 'retrieve'])->name('session.retrieve');

/**
 * Administrator area routes
 */
Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/', function () {
        return view('admin.index');
    })->name('admin');

    Route::resource('products', ProductsController::class);
    Route::resource('brands', BrandsController::class);
    Route::resource('images', ImagesController::class);
    Route::resource('product_images', ProductImagesController::class);
    Route::get('product_images/{product}/create', [ProductImagesController::class, 'create'])->name('product_images.create');

});

/**
 * Authentication routes
 */
Auth::routes();
