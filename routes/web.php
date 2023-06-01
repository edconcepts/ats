<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('hr')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('HR/Dashboard');
    })->name('hr.dashboard');

    Route::get('/statuses', function () {
        return Inertia::render('HR/Statuses/Overview');
    })->name('hr.statuses');

    Route::get('/statuses/create', function () {
        return Inertia::render('HR/Statuses/Create');
    })->name('hr.statuses.create');

    Route::get('/locations', function () {
        return Inertia::render('HR/Locations');
    })->name('hr.locations');
});

require __DIR__.'/auth.php';
