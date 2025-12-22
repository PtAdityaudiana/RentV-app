<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\UserData;

Route::get('/test', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API works'
    ]);
});

if (app()->environment('local')) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/users', [UserData::class, 'index']);
    Route::get('/users/{id}', [UserData::class, 'show']);
    Route::delete('/users/{id}', [UserData::class, 'delete']);

    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::get('/vehicles/{id}', [VehicleController::class, 'show']);
    Route::post('/vehicles/store', [VehicleController::class, 'vehiclesStore']);
    Route::post('/vehicles/dummy', [VehicleController::class, 'storeDummy']);
    Route::delete('/vehicles/delete/{id}', [VehicleController::class, 'delete']);

    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{id}', [BookingController::class, 'userBookings']);
    Route::put('/bookings/update/{id}', [BookingController::class, 'cancel']);
}

