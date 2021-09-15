<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AirportController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\AuthController;

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
Route::post('/register', [AuthController::class, 'register']); //Route to register a user
Route::post('/login', [AuthController::class, 'login']); //Route to log in a user


Route::group(['middleware' => ['auth:sanctum']], function() {
    //Using authentication for all routes that post put and delete

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => 'airports'], function () {
        Route::post('/', [AirportController::class, 'store']);
        Route::put('/{id}', [AirportController::class, 'update']);
        Route::delete('/{id}', [AirportController::class, 'destroy']);
    });

    Route::group(['prefix' => 'customers'], function () {
        Route::post('/', [CustomerController::class, 'store']);
        Route::put('/{id}', [CustomerController::class, 'update']);
        Route::delete('/{id}', [CustomerController::class, 'destroy']);
    });

    Route::group(['prefix' => 'flights'], function () {
        Route::post('/', [FlightController::class, 'store']);
        Route::put('/{id}', [FlightController::class, 'update']);
        Route::delete('/{id}', [FlightController::class, 'destroy']);
    });

    Route::group(['prefix' => 'planes'], function () {
        Route::post('/', [PlaneController::class, 'store']);
        Route::put('/{id}', [PlaneController::class, 'update']);
        Route::delete('/{id}', [PlaneController::class, 'destroy']);
    });

    Route::group(['prefix' => 'staff'], function () {
        Route::post('/', [StaffController::class, 'store']);
        Route::put('/{id}', [StaffController::class, 'update']);
        Route::delete('/{id}', [StaffController::class, 'destroy']);
    });
});

//No authentication for get requests
Route::group(['prefix' => 'airports'], function () {
    Route::get('/', [AirportController::class, 'index']);
    Route::get('/{id}', [AirportController::class, 'show']);
});

Route::group(['prefix' => 'customers'], function () {
    Route::get('/', [CustomerController::class, 'index']);
    Route::get('/{id}', [CustomerController::class, 'show']);
});

Route::group(['prefix' => 'flights'], function () {
    Route::get('/', [FlightController::class, 'index']);
    Route::get('/{id}', [FlightController::class, 'show']);
});

Route::group(['prefix' => 'planes'], function () {
    Route::get('/', [PlaneController::class, 'index']);
    Route::get('/{id}', [PlaneController::class, 'show']);
});

Route::group(['prefix' => 'staff'], function () {
    Route::get('/', [StaffController::class, 'index']);
    Route::get('/{id}', [StaffController::class, 'show']);
});