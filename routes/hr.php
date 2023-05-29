<?php

use App\Http\Controllers\HumanResources\ApplicationArchiveController;
use App\Http\Controllers\HumanResources\ApplicationInterviewController;
use App\Http\Controllers\HumanResources\ApplicationStatusController;
use App\Http\Controllers\HumanResources\DashboardController;
use App\Http\Controllers\HumanResources\LocationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HumanResources\StatusController;
use Inertia\Inertia;


//Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/application/{application}', [DashboardController::class, 'show_application'])->name('dashboard.application.show');

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


Route::resource('/statuses', StatusController::class)->only([
    'index', 'store' , 'create', 'edit', 'update'
]);
Route::put('/applications/{application}/status', [ApplicationStatusController::class, 'update'])->name('applications.status.update');
Route::post('/applications/{application}/interviews', [ApplicationInterviewController::class, 'store'])->name('applications.interviews.store');
Route::put('/applications/{application}/archive', [ApplicationArchiveController::class, 'update'])->name('applications.archive.update');

Route::resource('/locations' , LocationController::class)
    ->only(['index', 'edit', 'update']);

