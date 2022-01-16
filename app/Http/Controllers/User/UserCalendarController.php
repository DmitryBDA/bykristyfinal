<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use Illuminate\Http\Request;

class UserCalendarController extends Controller
{

    public function getDataRecordUser(Request $request){
        $recordId = $request->recordId;
        $services = Service::all();

        $record = Record::where('id' , $recordId)->first();
        $record->setAttr('services', $services);

        return response()->json($record);
    }

}
