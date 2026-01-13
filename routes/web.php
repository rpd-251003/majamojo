<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\SuperDealController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\TicketController as UserTicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

// Broadcasting Routes (for Pusher authentication)
Broadcast::routes(['middleware' => ['auth']]);

// Landing Page (Public)
Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        Route::prefix('games')->name('games.')->group(function () {
            Route::get('/', [GameController::class, 'index'])->name('index');
            Route::get('/data', [GameController::class, 'getData'])->name('data');
            Route::post('/', [GameController::class, 'store'])->name('store');
            Route::get('/{id}', [GameController::class, 'show'])->name('show');
            Route::put('/{id}', [GameController::class, 'update'])->name('update');
            Route::delete('/{id}', [GameController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [GameController::class, 'toggleStatus'])->name('toggle-status');
        });

        Route::prefix('vouchers')->name('vouchers.')->group(function () {
            Route::get('/', [VoucherController::class, 'index'])->name('index');
            Route::get('/data', [VoucherController::class, 'getData'])->name('data');
            Route::post('/', [VoucherController::class, 'store'])->name('store');
            Route::get('/{id}', [VoucherController::class, 'show'])->name('show');
            Route::put('/{id}', [VoucherController::class, 'update'])->name('update');
            Route::delete('/{id}', [VoucherController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [VoucherController::class, 'toggleStatus'])->name('toggle-status');
        });

        Route::prefix('events')->name('events.')->group(function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::get('/data', [EventController::class, 'getData'])->name('data');
            Route::post('/', [EventController::class, 'store'])->name('store');
            Route::get('/{id}', [EventController::class, 'show'])->name('show');
            Route::put('/{id}', [EventController::class, 'update'])->name('update');
            Route::delete('/{id}', [EventController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [EventController::class, 'toggleStatus'])->name('toggle-status');
        });

        Route::prefix('super-deals')->name('super-deals.')->group(function () {
            Route::get('/', [SuperDealController::class, 'index'])->name('index');
            Route::get('/data', [SuperDealController::class, 'getData'])->name('data');
            Route::post('/', [SuperDealController::class, 'store'])->name('store');
            Route::get('/{id}', [SuperDealController::class, 'show'])->name('show');
            Route::put('/{id}', [SuperDealController::class, 'update'])->name('update');
            Route::delete('/{id}', [SuperDealController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/toggle-status', [SuperDealController::class, 'toggleStatus'])->name('toggle-status');
        });

        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/data', [UserController::class, 'getData'])->name('data');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        });

        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [AdminTicketController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminTicketController::class, 'show'])->name('show');
            Route::post('/{id}/message', [AdminTicketController::class, 'sendMessage'])->name('message');
            Route::patch('/{id}/status', [AdminTicketController::class, 'updateStatus'])->name('update-status');
            Route::patch('/{id}/assign', [AdminTicketController::class, 'assignAdmin'])->name('assign');
            Route::patch('/{id}/priority', [AdminTicketController::class, 'updatePriority'])->name('update-priority');
        });
    });

    Route::middleware('role:membership,reguler')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');
        Route::get('/vouchers', [UserDashboard::class, 'vouchers'])->name('vouchers');
        Route::get('/events', [UserDashboard::class, 'events'])->name('events');
        Route::get('/super-deals', [UserDashboard::class, 'superDeals'])->name('super-deals');

        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::get('/', [UserTicketController::class, 'index'])->name('index');
            Route::get('/create', [UserTicketController::class, 'create'])->name('create');
            Route::post('/', [UserTicketController::class, 'store'])->name('store');
            Route::get('/{id}', [UserTicketController::class, 'show'])->name('show');
            Route::post('/{id}/message', [UserTicketController::class, 'sendMessage'])->name('message');
            Route::patch('/{id}/close', [UserTicketController::class, 'close'])->name('close');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
