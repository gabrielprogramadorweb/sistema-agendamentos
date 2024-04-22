<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Super\HomeController;
use App\Http\Controllers\Super\UnitsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Grouping 'super' prefix and 'auth' middleware
Route::prefix('super')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
// Automatically generate resource routes for units
    Route::resource('units', UnitsController::class)->names([
        'index' => 'units.index',  // Explicitly setting the name for clarity
        'create' => 'units.create',
        'store' => 'units.store',
        'edit' => 'units.edit',
        'update' => 'units.update',
        'destroy' => 'units.destroy'
    ]);
    // Units specific routes without redundant middleware
    Route::prefix('units')->group(function () {
        Route::get('/', [UnitsController::class, 'index'])->name('units.index');
        Route::get('/new', [UnitsController::class, 'create'])->name('units.create');
        Route::get('/{id}/edit', [UnitsController::class, 'edit'])
            ->where('id', '[0-9]+') // Ensure 'id' is numeric
            ->name('units.edit');
        Route::put('/{id}', [UnitsController::class, 'update'])->name('units.update');
    });
});
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes grouped under 'auth' middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
