<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutomationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Public Marketing / Selling Page
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated App Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reviews Inbox & Response Workspace
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('reviews.show');
    Route::post('/reviews/{id}/reply', [ReviewController::class, 'updateReply'])->name('reviews.reply');
    Route::post('/reviews/{id}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/send-demo', [ReviewController::class, 'sendDemo'])->name('reviews.send-demo');
    Route::post('/reviews/{id}/flag', [ReviewController::class, 'flag'])->name('reviews.flag');
    Route::post('/reviews/{id}/regenerate', [ReviewController::class, 'regenerate'])->name('reviews.regenerate');
    Route::post('/reviews/{id}/reprocess', [ReviewController::class, 'reprocess'])->name('reviews.reprocess');

    // Automation & Logs
    Route::get('/automation', [AutomationController::class, 'index'])->name('automation.index');
    Route::post('/automation/test-connection', [AutomationController::class, 'testConnection'])->name('automation.test');
    Route::post('/automation/logs/{id}/retry', [AutomationController::class, 'retryLog'])->name('automation.retry');

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/regenerate-secret', [SettingsController::class, 'regenerateSecret'])->name('settings.regenerate-secret');
});
