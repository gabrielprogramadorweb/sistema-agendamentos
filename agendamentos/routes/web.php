<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Super\HomeController;
use App\Http\Controllers\Super\ServiceController;
use App\Http\Controllers\Super\UnitsController;
use App\Http\Controllers\Super\UnitsServicesController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware('verified')->name('dashboard');

    Route::prefix('super')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home.index');

        Route::prefix('units')->group(function () {
            Route::post('/', [UnitsController::class, 'store'])->name('units.store');
            Route::get('/', [UnitsController::class, 'index'])->name('units.index');
            Route::get('/create', [UnitsController::class, 'create'])->name('units.create');
            Route::delete('/{id}', [UnitsController::class, 'destroy'])->where('id', '[0-9]+')->name('units.destroy');
            Route::get('/toggle/{id}', [UnitsController::class, 'toggleStatus'])->where('id', '[0-9]+')->name('units.toggleStatus');
            Route::get('/{id}/edit', [UnitsController::class, 'edit'])->where('id', '[0-9]+')->name('units.edit');
            Route::put('/{id}', [UnitsController::class, 'update'])->where('id', '[0-9]+')->name('units.update');

            // Route for viewing services related to a specific unit
            Route::get('/{id}/services', [UnitsServicesController::class, 'services'])->name('units.services');
            // Route to save services to a unit
            Route::put('/{id}/services/save', [UnitsServicesController::class, 'saveServices'])->name('units.services.save');
            // Assuming there's a need to store new services in a way similar to updating
            Route::post('/{id}/services/store', [UnitsServicesController::class, 'storeServices'])->name('units.services.store');
        });

        Route::prefix('services')->group(function () {
            Route::post('/', [ServiceController::class, 'store'])->name('services.store');
            Route::get('/', [ServiceController::class, 'index'])->name('services.index');
            Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
            Route::delete('/{id}', [ServiceController::class, 'destroy'])->where('id', '[0-9]+')->name('services.destroy');
            Route::get('/toggle/{id}', [ServiceController::class, 'toggleStatus'])->where('id', '[0-9]+')->name('services.toggleStatus');
            Route::get('/{id}/edit', [ServiceController::class, 'edit'])->where('id', '[0-9]+')->name('services.edit');
            Route::put('/{id}', [ServiceController::class, 'update'])->where('id', '[0-9]+')->name('services.update');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

