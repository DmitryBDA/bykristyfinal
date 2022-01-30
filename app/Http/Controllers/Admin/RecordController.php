<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Presenters\Record\RecordPresenter;
use App\Presenters\User\UserPresenter;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RecordController extends Controller
{
    protected $recordRepository;
    protected $userRepository;
    protected $recordServices;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
        $this->userRepository = app(UserRepository::class);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $this->recordRepository->addRecords($data);
    }

    public function cancel($recordId)
    {
        $result = $this->recordRepository->cancelRecord($recordId);

        return response()->json($result);
    }

    public function confirm($recordId)
    {
        $result = $this->recordRepository->confirmRecord($recordId);

        return response()->json($result);
    }

    public function delete($recordId)
    {
        $result = $this->recordRepository->deleteRecord($recordId);

        return response()->json($result);
    }

    public function getData($recordId, Request $request)
    {

        $record = $this->recordRepository->getById($recordId);
        $record = new RecordPresenter($record);

        $result = [
            'id' => $record->id,
            'time' => $record->time(),
            'dayWeek' => $record->dayWeek(),
            'date' => $record->startDate(),
            'selectedService' => $record->service_id ?? 1,
            'name' => $record->user ? (new UserPresenter($record->user))->fullName() : '',
            'title' => $record->title,
            'phone' => $record->user ? $record->user->phone : '',
            'statusRecord' => $record->status
        ];

        return response()->json($result);
    }

    public function update($recordId, Request $request, TelegramService $telegramService){

      $data = $request->all();
      //Получить запись по id
      $obRecord = $this->recordRepository->getById($recordId);

      //Сформировать новое дата время (2021-12-25 10:00)
      $date = Carbon::create($obRecord->start)->format('Y-m-d') . ' ' . $data['time'];
      //Данные для обновления
      $dataForSave = [
        'title' => $data['title'],
        'user_id' => null,
        'service_id' => null,
        'start' => $date,
        'end' => $date,
      ];

      if ($obRecord->status != 4) {
        //получить пользователя
        $user = $this->userRepository->getUser($data);
        $dataForSave['user_id'] = $user->id;
        $dataForSave['service_id'] = $data['serviceId'];
        $dataForSave['status'] = 3;

        if($obRecord->status == 1 || $obRecord->user_id != $user->id) {
          $telegramService->sendNotificationNewRecord($user, $obRecord);
        }
      }

      //Обновить данные записи
      $obRecord->update($dataForSave);

      return response()->json($obRecord);

    }
}
