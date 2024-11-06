<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\CakeSizeController;
use App\Http\Controllers\DashboardController;

Route::middleware(['web'])->group(function () {
    // Dashboard
    Route::get('/', [OrderController::class, 'summary']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders/today', [OrderController::class, 'todayOrders'])->name('orders.today');
    Route::get('/orders/calendar', [OrderController::class, 'calendar'])->name('orders.calendar');
    Route::resource('orders', OrderController::class);
    Route::get('/orders/{order}/print', [OrderController::class, 'printOrder'])->name('orders.print');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Cakes Management - Reorder these routes
    Route::get('/get-cake-sizes/{cake}', [CakeController::class, 'getSizes'])->name('cakes.get-sizes');
    Route::resource('cakes', CakeController::class)->except(['create', 'edit']);
    Route::post('/cakes/{cake}/sizes', [CakeSizeController::class, 'store'])->name('cake-sizes.store');
    Route::put('/cake-sizes/{size}', [CakeSizeController::class, 'update'])->name('cake-sizes.update');
    Route::delete('/cake-sizes/{size}', [CakeSizeController::class, 'destroy'])->name('cake-sizes.destroy');
});