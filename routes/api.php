<?php

use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/portfolio', [PortfolioController::class, 'ApiIndex'])->name('api.portfolip');
Route::get('/feedbacks', [FeedBackController::class, 'ApiIndex'])->name('api.feedbacks');
Route::middleware('throttle:1,1')->post('/contect-me', [PortfolioController::class, 'contect'])->name('api.contect-me');
