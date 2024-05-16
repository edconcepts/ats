<?php

use App\Http\Controllers\HumanResources\ApplicationArchiveController;
use App\Http\Controllers\HumanResources\ApplicationInterviewController;
use App\Http\Controllers\HumanResources\ApplicationStatusController;
use App\Http\Controllers\HumanResources\ArchiveStatusApplicationController;
use App\Http\Controllers\HumanResources\DashboardController;
use App\Http\Controllers\HumanResources\LocationController;
use App\Http\Controllers\HumanResources\SendNotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HumanResources\StatusController;
use App\Http\Controllers\HumanResources\VacancyController;
use Inertia\Inertia;

//TODO fix the middleware

//Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/application/{application}', [DashboardController::class, 'show_application'])->name('dashboard.application.show');
Route::get('/dashboard/create_application', [DashboardController::class, 'add_application'])->name('dashboard.application.create');
Route::post('/dashboard/create_application', [DashboardController::class, 'store_application'])->name('dashboard.application.store');

// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/send-notifications', [ SendNotificationController::class, 'index' ])->name('notification-send.index');
Route::post('/send-notifications', [ SendNotificationController::class, 'store' ])->name('notification-send.store');

Route::resource('/statuses', StatusController::class)->except([
    'show',
])->middleware('role:admin');

Route::resource('/vacancies', VacancyController::class)->only([
    'index', 'edit', 'store', 'create'
])->middleware('role:admin');

Route::post('/vacancies/{vacancy}/change-status/{status}', [VacancyController::class, 'changeStatus'])->name('vacancies.change-status')->middleware('role:admin');

Route::post('/vacancies/{vacancy}', [VacancyController::class, 'update'])->name('vacancies.update')->middleware('role:admin');

Route::post('/statuses/{status}/applications/archive', ArchiveStatusApplicationController::class)->name('statuses.applications.archive');

Route::put('/applications/{application}/status', [ApplicationStatusController::class, 'update'])->name('applications.status.update');
Route::post('/applications/{application}/interviews', [ApplicationInterviewController::class, 'store'])->name('applications.interviews.store');
Route::put('/applications/{application}/archive', [ApplicationArchiveController::class, 'update'])->name('applications.archive.update');

Route::resource('/locations' , LocationController::class)
    ->only(['index', 'edit', 'update'])->middleware('role:admin');
Route::post('/locations/{location}/login', [LocationController::class, 'login'])->name('locations.login');

