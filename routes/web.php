<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;

/* Public */
Route::get('/', [SiteController::class, 'landing'])->name('landing');
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

/* User auth */
Route::get('/user/register', [AuthController::class, 'showRegister'])->name('user.register');
Route::post('/user/register', [AuthController::class, 'register']);
Route::get('/user/login', [AuthController::class, 'showLogin'])->name('user.login');
Route::post('/user/login', [AuthController::class, 'login']);
Route::get('/user/logout', [AuthController::class, 'logout'])->name('user.logout');

/* User area */
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
Route::post('/booking/create', [BookingController::class, 'store'])->name('booking.store');
Route::get('/user/bookings', [BookingController::class, 'userBookings'])->name('user.bookings');


/* Admin area */
Route::prefix('admin')->group(function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // users
    Route::get('/users', [AdminController::class,'usersIndex'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class,'usersCreate'])->name('admin.users.create');
    Route::post('/users/store', [AdminController::class,'usersStore'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class,'usersEdit'])->name('admin.users.edit');
    Route::post('/users/{id}/update', [AdminController::class,'usersUpdate'])->name('admin.users.update');
    Route::post('/users/{id}/delete', [AdminController::class,'usersDelete'])->name('admin.users.delete');

    // vehicles
    Route::get('/vehicles', [AdminController::class,'vehiclesIndex'])->name('admin.vehicles.index');
    Route::get('/vehicles/create', [AdminController::class,'vehiclesCreate'])->name('admin.vehicles.create');
    Route::post('/vehicles/store', [AdminController::class,'vehiclesStore'])->name('admin.vehicles.store');
    Route::get('/vehicles/{id}/edit', [AdminController::class,'vehiclesEdit'])->name('admin.vehicles.edit');
    Route::post('/vehicles/{id}/update', [AdminController::class,'vehiclesUpdate'])->name('admin.vehicles.update');
    Route::post('/vehicles/{id}/delete', [AdminController::class,'vehiclesDelete'])->name('admin.vehicles.delete');

});
