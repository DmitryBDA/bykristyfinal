<?php

use App\Http\Controllers\Admin\CalendarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/calendar/create-records', [CalendarController::class,'createRecords'])->name('calendar.createRecords');
Route::post('/calendar/get-data-record', [CalendarController::class,'getDataRecord'])->name('calendar.getDataRecord');
Route::post('/calendar/add-user-to-record', [CalendarController::class,'addUserToRecord'])->name('calendar.addUserToRecord');
Route::post('/calendar/save-data-record', [CalendarController::class,'saveDataRecord'])->name('calendar.saveDataRecord');
Route::post('/calendar/cancel-record', [CalendarController::class,'cancelRecord'])->name('calendar.cancelRecord');
Route::post('/calendar/confirm-record', [CalendarController::class,'confirmRecord'])->name('calendar.confirmRecord');
Route::post('/calendar/delete-record', [CalendarController::class,'deleteRecord'])->name('calendar.deleteRecord');
Route::post('/calendar/get-list-active-records', [CalendarController::class,'getListActiveRecords'])->name('calendar.getListActiveRecords');
Route::post('/calendar/search-autocomplete', [CalendarController::class,'searchAutocomplete'])->name('calendar.searchAutocomplete');
