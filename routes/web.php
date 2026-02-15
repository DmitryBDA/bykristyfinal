<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\User\UserCalendarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController as AdminIndexController;
use App\Http\Controllers\User\IndexController as UserIndexController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\FinanceController;

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

Route::get('/records/{record_id}', [UserCalendarController::class, 'getDataRecordUser']);
Route::post('/records/{record_id}', [UserCalendarController::class, 'recordUser'])->name('userCalendar.recordUser');
Route::get('/service', [ServiceController::class, 'get']);
Route::get('/records', [CalendarController::class,'showRecordsWithStatusOne'])->name('calendar.showRecordsWithStatusOne');
Route::get('/data-user', [ClientController::class, 'getData'])->name('client.getData');

Route::middleware(['role:admin'])->prefix('admin')->group(function () {

  Route::get('/', [AdminIndexController::class, 'index'])->name('admin');

  Route::prefix('calendar')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('admin.calendar.index');
    Route::get('/show-records', [CalendarController::class, 'showRecords'])->name('admin.calendar.showRecords');
  });

  Route::prefix('clients')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('admin.client.index');
    Route::get('/{user_id}', [ClientController::class, 'show'])->name('admin.client.show');
    Route::put('/{user_id}', [ClientController::class, 'update'])->name('admin.client.update');
    Route::get('/sendnotification/{user_id}', [ClientController::class, 'sendNotification'])->name('admin.client.sendnotification');

  });

  Route::prefix('records')->group(function () {
    Route::get('/{record_id}', [RecordController::class, 'getData'])->name('admin.records.getData');
    Route::post('/', [RecordController::class, 'create'])->name('admin.records.create');
    Route::delete('/{record_id}', [RecordController::class, 'delete'])->name('admin.records.delete');
    Route::put('/cancel/{record_id}', [RecordController::class, 'cancel'])->name('admin.records.cancel');
    Route::put('/confirm/{record_id}', [RecordController::class, 'confirm'])->name('admin.records.confirm');
    Route::put('/{record_id}', [RecordController::class, 'update'])->name('admin.records.update');
    Route::get('/total/all',  [RecordController::class, 'total'])->name('admin.records.total');
  });

  Route::prefix('service')->group(function () {
    Route::get('/', [ServiceController::class, 'get']);
  });

  Route::prefix('finance')->group(function () {
    Route::get('/', [FinanceController::class, 'index'])->name('admin.finance.index');
  });

  Route::prefix('search')->group(function () {
    Route::get('/get-list-active-records', [SearchController::class, 'getActiveListsRecords'])->name('admin.search.getActiveListsRecords');
    Route::get('/input-name-autocomplete', [SearchController::class, 'inputNameAutocomplete'])->name('admin.search.inputNameAutocomplete');
  });

});
