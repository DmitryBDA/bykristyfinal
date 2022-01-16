<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\Admin\CalendarController;

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


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [UserIndexController::class, 'index'])->name('index');
Route::get('/record', function () {
    return redirect('/');
});
Route::post('/calendar/get-data-record-user', [\App\Http\Controllers\User\UserCalendarController::class,'getDataRecordUser']);

Route::middleware(['role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminIndexController::class, 'index'])->name('mainAdmin');
    Route::get('/calendar', [CalendarController::class,'index'])->name('calendar.index');
});
