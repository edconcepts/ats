<?php

use App\Http\Controllers\Hr\StatusController;
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

Route::get('/test',function(){
    //paterns
    // $pattern = [
    //     'name' => 'name',
    //     'kik_id' => 'id',
    //     'description' => 'description',
    //     'slug' => 'slug',
    // ];
    // $pattern = [
    //     'kik_id' => 'id',
    //     'slug' => 'slug',
    //     'title' => 'title.rendered',
    //     'kik_date' => 'date',
    //     'location_id' => 'vacancy-location.0',
    // ];
    // $pattern = [
    //     'kik_id' => 'id',
    //     'slug' => 'slug',
    //     'title' => 'title.rendered',
    //     'kik_date' => 'date',
    //     'vacancy_id' => 'meta.vacature'
    // ];

    // $vacancies = $a->execute('http://staging.werkenbijkik.nl/wp-json/wp/v2/solicitaties',$pattern);

    // Application::insert($vacancies);
    return 0;
});
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

require __DIR__.'/auth.php';
