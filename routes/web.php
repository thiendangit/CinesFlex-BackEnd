<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clear-cache', function() {
    $run = Artisan::call('config:clear');
    $run = Artisan::call('cache:clear');
    $run = Artisan::call('config:cache');
    return 'FINISHED';
});

// Route::resource('cinemas', CinemaController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', function() {
    return view('admin.index');
});

Route::resources([
    'movies'        => MovieController::class,
    'products'      => ProductController::class,
    'promotions'    => PromotionController::class,
]);

Route::resource('regions', 'RegionController');
Route::get('/regions/delete/{region}', 'RegionController@destroy')->name('regions.destroy');

Route::resource('cinemas', 'CinemaController');
Route::get('/cinemas/delete/{cinema}', 'CinemaController@destroy')->name('cinemas.destroy');