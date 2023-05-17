<?php

use App\Http\Controllers\HR\ApplicationStatusController;
use App\Http\Controllers\HR\DashboardController;
use App\Http\Controllers\HR\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HR\StatusController;
use Inertia\Inertia;


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('/statuses', StatusController::class)->only([
    'index', 'store' , 'create'
]);
Route::put('/applications/{application}/status', [ApplicationStatusController::class, 'update'])->name('applications.status.update');
Route::get('/locations' , [LocationController::class, 'index'])->name('locations.index');

