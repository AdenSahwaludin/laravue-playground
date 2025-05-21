<?php

use App\Http\Controllers\BelajarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('belajar')->group(function () {
    Route::get('/', [BelajarController::class, 'index'])->name('belajar');
    Route::get('say-hello', [BelajarController::class, 'sayHello'])->name('belajar.say-hello');
    Route::get('style', [BelajarController::class, 'style'])->name('belajar.style');
    Route::get('score', [BelajarController::class, 'score'])->name('belajar.score');
    Route::get('todolist', [BelajarController::class, 'todolist'])->name('belajar.todolist');

});

Route::middleware('auth')->group(function () {

    Route::resource('products', ProductController::class);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
