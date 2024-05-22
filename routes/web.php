<?php

use App\Http\Controllers\ApplicationDownloadResumeController;
use App\Http\Controllers\ApplicationNotesUpdateController;
use App\Http\Controllers\ApplicationTimeSlotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreManager\ApplicationStatusController;
use App\Http\Controllers\StoreManager\NotificationController;
use App\Http\Controllers\StoreManager\TimeSlotController;
use App\Http\Controllers\Webhooks\IndeedWebhookController;
use App\Http\Controllers\Webhooks\WerkzoekenWebhookController;
use Illuminate\Support\Facades\Route;

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



Route::middleware(['auth', '2fa'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('store-manager.notifications');

    Route::post('/notifications/mark-as-read/{notification}', [NotificationController::class, 'markAsRead'])
        ->name('store-manager.notifications.mark-as-read');

    Route::post('/notifications/mark-as-unread/{notification}', [NotificationController::class, 'markAsUnread'])
        ->name('store-manager.notifications.mark-as-unread');

    Route::post('/notifications/delete', [NotificationController::class, 'delete'])
        ->name('store-manager.notifications.delete');

    Route::get('/notifications/count', [NotificationController::class, 'getCount'])
        ->name('store-manager.notifications.count');

    Route::get('/notifications/data', [NotificationController::class, 'getNotifications'])
        ->name('store-manager.notifications.get-notifications');


    Route::post('/timeslots/store', TimeSlotController::class)
        ->name('store-manager.timeslot');

    Route::put('/applications/{application}/update_notes', ApplicationNotesUpdateController::class)->name('application.update_notes');
    Route::get('/applications/{application}/download_resume', ApplicationDownloadResumeController::class)->name('applications.download-resume');
    Route::get('/applications/{application}/statuses/{status}', [ApplicationStatusController::class, 'update'])->name('store-manager.application-status.update');
    Route::post('/applications/{application}/timeslot/{timeSlot}', [ApplicationTimeSlotController::class, 'store'])->name('application.timeslot.store');

});

Route::post('/webhooks/indeed', IndeedWebhookController::class)->name('webhooks.indeed');
Route::post('/webhooks/werkzoeken', WerkzoekenWebhookController::class)->name('webhooks.werkzoeken');

require __DIR__.'/auth.php';
