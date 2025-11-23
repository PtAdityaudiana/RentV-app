<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;


Route::get('/test-mw', function () {
    return "MW OK";
})->middleware('user');

// =========================
// Public Routes (No Login)
// =========================
Route::get('/', [SiteController::class, 'landing'])->name('landing');
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');


// =========================
// User Authentication
// =========================
Route::get('/user/register', [AuthController::class, 'showRegister'])->name('user.register');
Route::post('/user/register', [AuthController::class, 'register']);

Route::get('/user/login', [AuthController::class, 'showLogin'])->name('user.login');
Route::post('/user/login', [AuthController::class, 'login']);

Route::get('/user/logout', [AuthController::class, 'logout'])
    ->middleware('user')
    ->name('user.logout');


// =========================
// Protected User Area
// =========================
Route::middleware('user')->group(function () {

    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])
        ->name('user.profile.update');

    Route::get('/user/profile', [UserController::class, 'editProfile'])
        ->name('user.profile.edit');

    Route::post('/booking/create', [BookingController::class, 'store'])
        ->name('booking.store');

    // history booking user
    Route::get('/user/bookings', [BookingController::class, 'userBookings'])
        ->name('user.bookingshistory');
});


// =========================
// ADMIN AUTH
// =========================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::get('/admin/logout', [AdminAuthController::class, 'logout'])
    ->middleware('admin')
    ->name('admin.logout');


// =========================
// Protected Admin Area
// =========================
Route::prefix('admin')->middleware('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // ----- Manage Users -----
    Route::get('/users', [AdminController::class,'usersIndex'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class,'usersCreate'])->name('admin.users.create');
    Route::post('/users/store', [AdminController::class,'usersStore'])->name('admin.users.store');
    Route::post('/users/{id}/update', [AdminController::class,'usersUpdate'])->name('admin.users.update');
    Route::post('/users/{id}/delete', [AdminController::class,'usersDelete'])->name('admin.users.delete');
    Route::get('/users/{id}/edit', [AdminController::class,'usersEdit'])->name('admin.users.edit');

    // ----- Manage Vehicles -----
    Route::get('/vehicles', [AdminController::class,'vehiclesIndex'])->name('admin.vehicles.index');
    Route::get('/vehicles/create', [AdminController::class,'vehiclesCreate'])->name('admin.vehicles.create');
    Route::post('/vehicles/store', [AdminController::class,'vehiclesStore'])->name('admin.vehicles.store');
    Route::post('/vehicles/{id}/update', [AdminController::class,'vehiclesUpdate'])->name('admin.vehicles.update');
    Route::post('/vehicles/{id}/delete', [AdminController::class,'vehiclesDelete'])->name('admin.vehicles.delete');
    Route::get('/vehicles/{id}/edit', [AdminController::class,'vehiclesEdit'])->name('admin.vehicles.edit');

    // ----- Manage Bookings -----
    Route::get('/bookings', [AdminController::class,'bookingsIndex'])->name('admin.bookings.index');
    Route::post('/bookings/{id}/approve', [AdminController::class,'bookingApprove'])->name('admin.bookings.approve');
    Route::post('/bookings/{id}/reject', [AdminController::class,'bookingReject'])->name('admin.bookings.reject');

    Route::post('/bookings/{id}/return', [AdminController::class, 'bookingReturn'])
        ->name('admin.bookings.return');

    Route::post('/bookings/{id}/late', [AdminController::class, 'bookingLate'])
        ->name('admin.bookings.late');
});
