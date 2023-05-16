<?php

use App\Http\Controllers\Hr\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hr\StatusController;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('HR/Dashboard');
})->name('dashboard');

Route::resource('/statuses', StatusController::class)->only([
    'index', 'store' , 'create'
]);

Route::get('/locations' , [LocationController::class, 'index'])->name('locations.index');

