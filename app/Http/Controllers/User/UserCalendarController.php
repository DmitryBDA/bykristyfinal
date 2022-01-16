<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Presenters\Record\RecordPresenter;
use App\Presenters\User\UserPresenter;
use App\Repositories\RecordRepository;
use Illuminate\Http\Request;

class UserCalendarController extends Controller
{

    protected $recordRepository;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
    }

    public function getDataRecordUser(Request $request){
        $recordId = $request->recordId;

        $record = $this->recordRepository->getById($recordId);
        $record = new RecordPresenter($record);

        $result = [
            'id'                => $record->id,
            'time'              => $record->time(),
            'dayWeek'           => $record->dayWeek(),
            'date'              => $record->startDate(),
        ];

        return response()->json($result);
    }

}
