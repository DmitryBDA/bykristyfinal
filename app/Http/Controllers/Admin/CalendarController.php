<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CalendarController extends Controller
{
    protected $recordRepository;
    protected $userRepository;
    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    public function index(){
        return view('admin.pages.calendar');
    }

    public function showRecords()
    {

        $recordList = $this->recordRepository->getActiveRecords();
        return response()->json($recordList);
    }

    public function createRecords(Request $request)
    {
        $this->recordRepository->addRecords($request);
    }

    public function getDataRecord(Request $request)
    {

        $recordId = $request->recordId;
        $services = Service::all();

        $record = Record::where('id' , $recordId)->with('user')->first();
        $record->setAttr('services', $services);

        return response()->json($record);

    }

    public function addUserToRecord(Request $request){
        $data = $request->all();
        $record = Record::find($data['recordId']);

        $user = User::where('phone', $data['phone'])->first();

        if (!$user) {
            $user = $this->userRepository->createUser($request);
        }

        $record->update([
            'user_id' => $user->id,
            'status' => 3,
            'service_id' => $data['serviceId']
        ]);

        return response()->json($record);
    }

    public function cancelRecord(Request $request){
        $recordId = $request->recordId;

        $obRecord = Record::find($recordId);
        $obRecord->update([
            'status' => 1,
            'user_id' => null,
            'service_id' => null,
        ]);
        return response()->json($obRecord);
    }

    public function confirmRecord(Request $request){
        $recordId = $request->recordId;

        $obRecord = Record::find($recordId);
        $obRecord->update(['status' => 3]);
        return response()->json($obRecord);
    }

    public function deleteRecord(Request $request){
        $recordId = $request->recordId;
        $obRecord = Record::find($recordId)->delete();

        return response()->json($obRecord);
    }

    public function getListActiveRecords(Request $request){
        $strSearch = $request->strSearch;
        $recordList = $this->recordRepository->getListActiveRecords($strSearch);
        return response()->json($recordList);
    }
}
