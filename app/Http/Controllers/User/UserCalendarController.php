<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Models\Service;
use App\Presenters\Record\RecordPresenter;
use App\Presenters\User\UserPresenter;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class UserCalendarController extends Controller
{

    protected $recordRepository;
    protected $userRepository;


    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    public function getDataRecordUser($recordId)
    {
        $obRecord = $this->recordRepository->getById($recordId);
        $obRecord = new RecordPresenter($obRecord);

        $result = [
            'id' => $obRecord->id,
            'time' => $obRecord->time(),
            'dayWeek' => $obRecord->dayWeek(),
            'date' => $obRecord->startDate(),
        ];

        return response()->json($result);
    }

    public function recordUser($recordId, Request $request, TelegramService $telegramService)
    {

        $obRecord = $this->recordRepository->getById($recordId);

        if ($obRecord->status != 1) {
            return response()->json('busy');
        }

        $data = $request->all();
        $obUser = $this->userRepository->getUser($data);

        $obRecord->update([
            'user_id' => $obUser->id,
            'service_id' => $data['serviceId'],
            'status' => 2
        ]);
        $telegramService->sendNotificationNewRecord($obUser, $obRecord);
        return response()->json($obRecord);

    }

}
