<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Presenters\Record\RecordPresenter;
use App\Presenters\User\UserPresenter;
use App\Repositories\RecordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

class RecordController extends Controller
{
    protected $recordRepository;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
    }

    public function create(Request $request){
        $data = $request->all();
        $this->recordRepository->addRecords($data);
    }

    public function cancel(Request $request){
        $data = $request->all();
        $result = $this->recordRepository->cancelRecord($data);

        return response()->json($result);
    }

    public function confirm(Request $request){
        $data = $request->all();
        $result = $this->recordRepository->confirmRecord($data);

        return response()->json($result);
    }

    public function delete(Request $request){
        $data = $request->all();
        $result = $this->recordRepository->deleteRecord($data);

        return response()->json($result);
    }

    public function getData(Request $request)
    {
        $recordId = $request->recordId;

        $record = $this->recordRepository->getById($recordId);
        $record = new RecordPresenter($record);

        $result = [
            'id'                => $record->id,
            'time'              => $record->time(),
            'dayWeek'           => $record->dayWeek(),
            'date'              => $record->startDate(),
            'selectedService'   => $record->service_id ?? 1,
            'name'              => $record->user ? (new UserPresenter($record->user))->fullName(): '',
            'title'             => $record->title,
            'phone'             => $record->user ? $record->user->phone : '',
            'statusRecord'      => $record->status
        ];

        return response()->json($result);
    }
}
