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

Route::prefix('super')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::prefix('units')->middleware('auth')->group(function () {
        Route::get('/', [UnitsController::class, 'index'])->name('units');
        Route::get('/units/new', 'App\Http\Controllers\Super\UnitsController@create')->name('units.new');

    });
});

Route::get('/super', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
