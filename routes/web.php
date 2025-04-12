<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    Route::post('/portfolio', [PortfolioController::class, 'store'])->name('portfolio.store');
    
    Route::post('/edit-portfolio', [PortfolioController::class, 'edit'])->name('portfolio.edit');
    Route::post('/delete-portfolio', [PortfolioController::class, 'delete'])->name('portfolio.delete');

    Route::post('/upload', [PortfolioController::class, 'upoadImage'])->name('upload-image');
});

require __DIR__.'/auth.php';
