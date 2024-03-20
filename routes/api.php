<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->group( function () {
// });

Route::middleware('api')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');
    Route::post('/register', 'App\Http\Controllers\AuthController@register')->name('register');

    Route::post('/artists', 'App\Http\Controllers\UserController@artists');
    Route::post('/genres', 'App\Http\Controllers\UserController@genres');
    Route::post('/uploads', 'App\Http\Controllers\UploadController@index');
    Route::get('/cover/{filename}', 'App\Http\Controllers\UploadController@showCover');
    Route::get('/content/{filename}', 'App\Http\Controllers\UploadController@showContent');
});

Route::middleware('auth.jwt')->group(function () {
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('/me', 'App\Http\Controllers\AuthController@me');
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
});

Route::group([
    'prefix' => 'artist',
    'middleware' => ['auth.jwt', 'artist']
], function () {
    Route::post('/upload', 'App\Http\Controllers\UploadController@store');
    Route::post('/upload/album', 'App\Http\Controllers\AlbumController@create');
});

Route::group([
    'prefix' => 'admin/manage-users',
    'middleware' => ['auth.jwt', 'admin']
], function () {
    Route::post('/', 'App\Http\Controllers\UserController@users');
    Route::post('/activate/{id}', 'App\Http\Controllers\UserController@activateUser');
    Route::post('/deactivate/{id}', 'App\Http\Controllers\UserController@deactivateUser');
    Route::post('/update/{id}', 'App\Http\Controllers\UserController@updateUser');
    Route::post('/delete/{id}', 'App\Http\Controllers\UserController@deleteUser');
    Route::post('/verify-to-artist/{id}', 'App\Http\Controllers\UserController@verifyToArtist');
});


Route::group([
    'prefix' => 'email', 
    'as' => 'verification.'
], function () {
    Route::get('/verify/{id}', 'App\Http\Controllers\VerificationController@verify')
        ->middleware(['signed'])->name('verify');
    Route::post('/send-verification', 'App\Http\Controllers\VerificationController@send')
        ->name('send');
});

