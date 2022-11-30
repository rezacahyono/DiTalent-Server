<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfluenceController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\TalentController;
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

Route::middleware('auth:sanctum')->group(function () {
    // Route get user temp
    Route::get('auth/me', [AuthController::class, 'me']);

    /**
     * Route Auth
     */
    Route::post('auth/update', [AuthController::class, 'update'])->name('update');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

    /**
     * Route Talent
     */
    Route::apiResources(['talent' => TalentController::class]);

    /**
     * Route Social Media
     */
    Route::apiResources(['social-media' => SocialMediaController::class]);

    /**
     * Route Influence Cat
     */
    Route::apiResources(['talent/influence' => InfluenceController::class]);
});

Route::post('auth/login', [AuthController::class, 'login'])->name('login');
Route::post('auth/register', [AuthController::class, 'register'])->name('register');
