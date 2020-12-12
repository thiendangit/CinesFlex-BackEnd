<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::resource('/', HomeController::class);

Route::group(['namespace' => 'Auth'], function() {
    Route::post('/login', 'ApiAuthController@login')->name('login.api');
    Route::post('/register', 'ApiAuthController@register')->name('register.api');
});

Route::middleware('auth:api')->group(function () {
    Route::group(['namespace' => 'Auth'], function() {
        Route::post('/logout', 'ApiAuthController@logout')->name('logout.api');
    });
    Route::group(['namespace' => 'Api'], function() {
        Route::apiResources([
            'movies'        => MovieController::class,
            'regions'       => RegionController::class,
            'cinemas'       => CinemaController::class,
            'movie-screens' => MovieScreenController::class,
            'products'      => ProductController::class,
        ]);

        Route::post('/movie-screens/show-times-by-movie-n-region', 'MovieScreenController@showTimesByMovieNRegion');
        Route::post('/movie-screens/show-times-by-movie-n-cinema', 'MovieScreenController@showTimesByMovieNCinema');
        Route::post('/seats/get-list-by-screen', 'SeatController@getListByScreen');
    });

});
