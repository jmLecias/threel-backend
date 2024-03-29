<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;


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

Route::middleware('jwt.verify')->group(function () {
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('/refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('/me', 'App\Http\Controllers\AuthController@me');
});

Route::middleware('api')->group(function () {
    Route::post('/login', 'App\Http\Controllers\AuthController@login')
        ->name('login');
    Route::post('/register', 'App\Http\Controllers\AuthController@register')
        ->name('register');
});


Route::group(['prefix' => 'email', 'as' => 'verification.'], function () {
    Route::get('/verify/{id}', 'App\Http\Controllers\VerificationController@verify')
        ->middleware(['signed'])->name('verify');
    Route::post('/send-verification', 'App\Http\Controllers\VerificationController@send')
        ->name('send');
});