<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Models\User;
use App\Presenters\Record\RecordPresenter;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\RecordService;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    protected $recordRepository;
    protected $userRepository;
    protected $recordService;
    protected $telegramService;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->recordService = new RecordService();
        $this->telegramService = new TelegramService();
    }

    public function index(){
        return view('admin.pages.calendar');
    }

    public function showRecords()
    {
        $recordList = $this->recordRepository->getAllFromToday();
        $recordList = $this->recordService->addAttrClassName($recordList);
        return response()->json($recordList);
    }

    public function showRecordsForUsers()
    {

        $recordList = $this->recordRepository->getActiveRecordsForUsers();
        return response()->json($recordList);
    }





    public function getListActiveRecords(Request $request){
        $strSearch = $request->strSearch;
        $recordList = $this->recordRepository->getListActiveRecords($strSearch);
        return response()->json($recordList);
    }

    public function searchAutocomplete(Request $request)
    {
        $query = $request->str;
        $arNames = $this->userRepository->searchAutocomplete($query);
        return response()->json($arNames);
    }

    public function recordUser(Request $request){
        $data = $request->all();
        $record = Record::find($data['recordId']);

        if($record->status != 1){
            return response()->json('busy');
        }
        $phone = str_replace(['+7', '(', ')', ' ', '-'],'',$data['phone']);

        $user = $this->userRepository->getUser($data);

        $record->update([
            'user_id' => $user->id,
            'service_id' => $data['serviceId'],
            'status' => 2
        ]);
        $this->telegramService->sendNotificationNewRecord($user, $record);
        return response()->json($record);

    }
}
