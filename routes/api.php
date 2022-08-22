<?php

use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);


Route::post('sendSMS', [AuthController::class, 'sendSMS']);

Route::group(['middleware' => 'api'], function () {
    Route::get('agent-profile', [AuthController::class, 'agentProfile']);
    Route::post('profile-update', [AuthController::class, 'profileUpdate']);
    Route::post('request-promotion', [AuthController::class, 'promoteRequest']);
});
