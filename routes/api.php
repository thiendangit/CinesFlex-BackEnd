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

Route::group(['namespace' => 'Api'], function() {
    Route::apiResources([
        'movies'        => MovieController::class,
        'regions'       => RegionController::class,
        'cinemas'       => CinemaController::class,
        'movie-screens' => MovieScreenController::class,
        'products'      => ProductController::class,
        'users'         => UserController::class,
        'promotions'    => PromotionController::class,
        'gifts'         => GiftController::class,
    ]);

    // movie scren
    Route::post('/movie-screens/show-times-by-movie-n-region', 'MovieScreenController@showTimesByMovieNRegion');
    Route::post('/movie-screens/show-times-by-movie-n-cinema', 'MovieScreenController@showTimesByMovieNCinema');

    // seat
    Route::post('/seats/get-list-by-screen', 'SeatController@getListByScreen');

    // product
    Route::post('/products/get-list-by-type', 'ProductController@getListByType');

    // movie
    Route::post('/movies/search', 'MovieController@search');

    // voucher
    Route::post('/vouchers/apply', 'VoucherController@apply');
    
});

Route::middleware('auth:api')->group(function () {
    Route::group(['namespace' => 'Auth'], function() {
        Route::post('/logout', 'ApiAuthController@logout')->name('logout.api');
    });

    Route::group(['namespace' => 'Api'], function() {
        // order
        Route::post('/orders/booking-ticket', 'OrderController@bookingTicket');
        Route::post('/orders/fetch-history', 'OrderController@fetchHistory');

        // user
        Route::post('/users/update-profile', 'UserController@updateProfile');
        Route::post('/users/get-profile', 'UserController@getProfile');
    });

});
