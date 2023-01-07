<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MatterController;
use App\Http\Controllers\AppointmentController;

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

Route::get('check', [LoginController::class, 'check']);


Route::middleware('guest')->group(function () {
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::post('logout', [LoginController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    Route::resource('matters', MatterController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('appointments/calendar/{year}/{month}', [AppointmentController::class, 'get_calendar']);
    // , ['only' => ['index', ]]
});
