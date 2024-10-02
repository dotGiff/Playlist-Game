<?php

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [Dashboard::class, 'show'])->name('dashboard');

    Route::post('/season/store', [SeasonController::class, 'store'])->name('season.store');
    Route::get('/season/create', [SeasonController::class, 'create'])->name('season.create');
    Route::post('/season/destroy/{seasonId}', [SeasonController::class, 'destroy'])->name('season.destroy');
    Route::post('/season/{seasonId}/round/store', [RoundController::class, 'store'])->name('round.store');
    Route::post('/season/{seasonId}/round/{roundId}/delete', [RoundController::class, 'destroy'])->name('round.destroy');
    Route::post('/season/{seasonId}/round/{roundId}/scores', [RoundController::class, 'submitScores'])->name('round.submit-scores');
    Route::get('/season/{seasonId}/round/{roundId}/scores', [RoundController::class, 'showScores'])->name('round.scores');
    Route::post('/season/{seasonId}/round/{roundId}/submission', [SubmissionController::class, 'store'])->name('submission.store');
    Route::put('/season/{seasonId}/round/{roundId}/close', [RoundController::class, 'close'])->name('round.close');
    Route::get('/season/{seasonId}/round/{roundId}', [RoundController::class, 'show'])->name('round');
    Route::get('/season/{seasonId}', [SeasonController::class, 'show'])->name('season');
});
