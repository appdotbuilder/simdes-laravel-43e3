<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LetterRequestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Letter Requests
    Route::resource('letter-requests', LetterRequestController::class);
    
    // Admin routes
    Route::middleware(\App\Http\Middleware\CheckRole::class.':admin')->group(function () {
        // Admin-specific routes will be added here
    });
    
    // Village Head routes  
    Route::middleware(\App\Http\Middleware\CheckRole::class.':village_head')->group(function () {
        // Village head-specific routes will be added here
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
