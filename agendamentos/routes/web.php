<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\Super\HomeController;
use App\Http\Controllers\Super\ServiceController;
use App\Http\Controllers\Super\UnitsController;
use App\Http\Controllers\Super\UnitsServicesController;
use App\Http\Controllers\WebHomeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//Route::post('/super/units/{id}/services/store', [UnitsServicesController::class, 'storeServices'])->name('units.services.store');
Route::get('/', [WebHomeController::class, 'index'])->name('web-home.index');
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
            Route::get('/{id}/services', [UnitsServicesController::class, 'services'])->name('units.services');
            Route::post('/{id}/services/store', [UnitsServicesController::class, 'storeServices'])->name('units.services.store');
            Route::put('/{id}/services/save', [UnitsServicesController::class, 'saveServices'])->name('units.services.save');
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
//rotas de agendamentos do user logado
Route::prefix('schedules')->group(function () {
    Route::get('/', [SchedulesController::class, 'index'])->name('schedules.new');
    Route::get('/services/{unitId}', [SchedulesController::class, 'unitServices'])->name('get.unit.services');
    Route::get('/calendar', [SchedulesController::class, 'getCalendar'])->name('get.calendar');
    Route::get('/hours', [SchedulesController::class, 'getHours'])->name('get.hours');
});

require __DIR__.'/auth.php';
