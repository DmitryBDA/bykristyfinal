<?php

use App\Http\Controllers\Admin\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Controllers\Admin\ServiceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/calendar/show-records', [CalendarController::class,'showRecords'])->name('calendar.showRecords');
Route::get('/calendar/show-records-users', [CalendarController::class,'showRecordsForUsers'])->name('calendar.showRecordsForUsers');



Route::post('/calendar/save-data-record', [CalendarController::class,'saveDataRecord'])->name('calendar.saveDataRecord');
Route::post('/calendar/get-list-active-records', [CalendarController::class,'getListActiveRecords'])->name('calendar.getListActiveRecords');
Route::post('/calendar/search-autocomplete', [CalendarController::class,'searchAutocomplete'])->name('calendar.searchAutocomplete');
Route::post('/calendar/record-user', [CalendarController::class,'recordUser'])->name('calendar.recordUser');

Route::post('/calendar/cancel-record', [RecordController::class,'cancel'])->name('record.cancel');
Route::post('/calendar/confirm-record', [RecordController::class,'confirm'])->name('record.confirm');
Route::post('/calendar/delete-record', [RecordController::class,'delete'])->name('record.delete');
Route::post('/calendar/create-records', [RecordController::class,'create'])->name('record.create');
Route::post('/calendar/get-data-record', [RecordController::class,'getData'])->name('record.getData');
Route::post('/calendar/add-user-to-record', [RecordController::class,'addUser'])->name('record.addUser');

Route::get('/calendar/get-services', [ServiceController::class,'getAll']);
