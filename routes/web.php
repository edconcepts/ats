<?php

use App\Http\Controllers\ApplicationTimeSlotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreManager\ApplicationStatusController;
use App\Http\Controllers\StoreManager\TimeSlotController;
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

Route::get('/test',function(){
    return 0;
});
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/timeslots/store', TimeSlotController::class)
    ->name('store-manager.timeslot');

Route::get('/applications/{application}/statuses/{status}', [ApplicationStatusController::class, 'update'])->name('store-manager.application-status.update');
Route::post('/applications/{application}/timeslot/{timeSlot}', [ApplicationTimeSlotController::class, 'store'])->name('application.timeslot.store');
require __DIR__.'/auth.php';
