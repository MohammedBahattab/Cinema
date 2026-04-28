<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\StudioController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CrewController;
use App\Http\Controllers\Admin\HallController;
use App\Http\Controllers\Admin\ShowtimeController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [MovieController::class, 'search'])->name('movies.search');
Route::get('/movies/{id}', [HomeController::class, 'showMovie'])->name('movies.show');
// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Booking Flow
Route::get('/showtimes/{showtime}/seats', [BookingController::class, 'selectSeats'])->name('booking.seats');
Route::post('/showtimes/{showtime}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
Route::post('/showtimes/{showtime}/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/bookings/{booking}/invoice', [BookingController::class, 'invoice'])->name('booking.invoice');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('movies', AdminMovieController::class);
    Route::resource('bookings', \App\Http\Controllers\Admin\BookingController::class)->only(['index', 'show', 'destroy']);
    Route::resource('studios', StudioController::class)->except(['show']);
    
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    
    Route::get('/crew', [CrewController::class, 'index'])->name('crew.index');
    Route::post('/crew/role', [CrewController::class, 'storeRole'])->name('crew.storeRole');
    Route::delete('/crew/role/{role}', [CrewController::class, 'destroyRole'])->name('crew.destroyRole');
    Route::post('/crew/member', [CrewController::class, 'storeCrew'])->name('crew.storeCrew');
    Route::get('/crew/member/{crew}/edit', [CrewController::class, 'edit'])->name('crew.edit');
    Route::put('/crew/member/{crew}', [CrewController::class, 'update'])->name('crew.update');
    Route::delete('/crew/member/{crew}', [CrewController::class, 'destroy'])->name('crew.destroy');
    
    Route::resource('halls', HallController::class)->except(['edit', 'update']);
    Route::resource('showtimes', ShowtimeController::class)->only(['index', 'create', 'store', 'destroy']);
});