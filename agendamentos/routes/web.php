<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Super\HomeController;
use App\Http\Controllers\Super\UnitsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('super')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);

    Route::prefix('units')->group(function () {
        Route::post('/', [UnitsController::class, 'store'])->name('units.store');
        Route::get('/', [UnitsController::class, 'index'])->name('units.index');
        Route::get('/create', [UnitsController::class, 'create'])->name('units.create');
        Route::get('/toggle/{id}', [UnitsController::class, 'toggleStatus'])->name('units.toggleStatus');
        Route::get('/{id}/edit', [UnitsController::class, 'edit'])
            ->where('id', '[0-9]+')
            ->name('units.edit');
        Route::put('/{id}', [UnitsController::class, 'update'])->name('units.update');
    });
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
