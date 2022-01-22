<?php

use App\Http\Controllers\Admin\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\User\UserCalendarController;
use App\Http\Controllers\Admin\SearchController;

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




Route::post('/search/get-list-active-records', [SearchController::class,'getActiveListsRecords'])->name('search.getActiveListsRecords');
Route::post('/search/input-name-autocomplete', [SearchController::class,'inputNameAutocomplete'])->name('search.inputNameAutocomplete');

Route::post('/calendar/record-user', [UserCalendarController::class,'recordUser'])->name('userCalendar.recordUser');

Route::post('/record/cancel-record', [RecordController::class,'cancel'])->name('record.cancel');
Route::post('/record/confirm-record', [RecordController::class,'confirm'])->name('record.confirm');
Route::post('/record/delete-record', [RecordController::class,'delete'])->name('record.delete');
Route::post('/record/create-records', [RecordController::class,'create'])->name('record.create');
Route::post('/record/get-data-record', [RecordController::class,'getData'])->name('record.getData');
Route::post('/record/add-user-to-record', [RecordController::class,'addUser'])->name('record.addUser');
Route::post('/record/save-data-record', [RecordController::class,'saveData'])->name('record.saveDataRecord');

Route::get('/service/get-services', [ServiceController::class,'getAll']);
