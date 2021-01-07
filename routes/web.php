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
    return view('homes');
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
    return view('home');
});

Route::resource('regions', 'RegionController');
Route::get('/regions/delete/{region}', 'RegionController@destroy')->name('regions.destroy');

Route::resource('cinemas', 'CinemaController');
Route::get('/cinemas/delete/{cinema}', 'CinemaController@destroy')->name('cinemas.destroy');

Route::resource('casters', 'CasterController');
Route::get('/casters/delete/{caster}', 'CasterController@destroy')->name('casters.destroy');

Route::resource('languages', 'LanguageController');
Route::get('/languages/delete/{language}', 'LanguageController@destroy')->name('languages.destroy');

Route::resource('categories', 'CategoryController');
Route::get('/categories/delete/{category}', 'CategoryController@destroy')->name('categories.destroy');

Route::resource('screens', 'ScreenController');
Route::get('/screens/delete/{screen}', 'ScreenController@destroy')->name('screens.destroy');

Route::resource('promotions', 'PromotionController');
Route::get('/promotions/delete/{promotion}', 'PromotionController@destroy')->name('promotions.destroy');

Route::resource('products', 'ProductController');
Route::get('/products/delete/{product}', 'ProductController@destroy')->name('products.destroy');

Route::resource('movies', 'MovieController');
Route::get('/movies/delete/{movie}', 'MovieController@destroy')->name('movies.destroy');