<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hr\StatusController;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('HR/Dashboard');
})->name('dashboard');

Route::resource('/statuses', StatusController::class)->only([
    'index', 'store' , 'create'
]);
Route::get('/locations', function () {
    return Inertia::render('HR/Locations');
})->name('locations');
