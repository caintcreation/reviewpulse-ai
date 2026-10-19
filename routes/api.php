<?php

use App\Http\Controllers\Api\ReviewIntakeController;
use Illuminate\Support\Facades\Route;

// Public/Platform Review Intake API
Route::post('/reviews', [ReviewIntakeController::class, 'intake']);

// Internal Automation / n8n / Gemini Callback
Route::post('/internal/reviews/{review}/analysis', [ReviewIntakeController::class, 'analysisCallback']);
