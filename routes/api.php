<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PollController;
use App\Http\Controllers\UserVoteController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth.api'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'profil']);
        Route::post('/reset-password', [AuthController::class, 'reset']);
    });
    
    Route::resource('/poll', PollController::class);
    Route::get('/poll/{poll_id}/vote/{pilihan_id}', [UserVoteController::class, 'choice']);
});

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
