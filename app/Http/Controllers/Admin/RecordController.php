<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CreateRecordDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRecordRequest;
use App\Models\Record;
use App\Models\User;
use App\Presenters\Record\RecordPresenter;
use App\Presenters\User\UserPresenter;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\RecordService;
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

    public function create(CreateRecordRequest $request)
    {
        $dto = CreateRecordDto::fromRequest($request);
        $this->recordRepository->addRecords($dto);
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

    public function getData($recordId, Request $request, RecordService $recordService)
    {

        $record = $this->recordRepository->getById($recordId);
        if($record->user){
          $otherRecords = $this->recordRepository->getRecordsByUserId($record->user->id, $record->start);
          $otherTimeRecords = $recordService->modArrOtherTime($otherRecords);
        }
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
            'statusRecord' => $record->status,
            'comment' => $record->comment,
            'otherTimeRecords' => $otherTimeRecords ?? [],
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
        'comment' => $data['comment']
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

    public function total()
    {
      $data = now()->subMonth(2);
      $nameMonth = [
        now()->subMonth(2)->monthName,
        now()->subMonth(1)->monthName,
        now()->monthName,
      ];

      $countNewUsers = [
        $this->getCountNewUsers(now()->subMonth(2)),
        $this->getCountNewUsers(now()->subMonth(1)),
        $this->getCountNewUsers(now()),
      ];

      $firstDay = $data->format('Y-m-01');
      $lastDay = date('Y-m-t');

      $recordTotal = Record::toBase()
        ->select('id', 'start')
        ->where('start', '>=', $firstDay)
        ->where('status', '=', 3)
        ->where('start', '<=', $lastDay)
        ->get();

      $arr = [];

      foreach ($recordTotal as $record) {
        $numberMonth = Carbon::create($record->start)->month;
        $lastNumberMonth = $numberMonth;
        if($numberMonth == $lastNumberMonth){
          if(array_key_exists($numberMonth, $arr)){
            $arr[$numberMonth] = $arr[$numberMonth] + 1;
          } else {
            $arr[$numberMonth] = 1;
          }

        }
      }
      $newAr = [];
      foreach ($arr as $item){
        $newAr[] = $item;
      }
     $data =[
       'nameMonth' => $nameMonth,
       'countClients' => $newAr,
       'countNewUsers' => $countNewUsers
     ];
      return response()->json($data);
    }

    private function getCountNewUsers($date){
      $firstDay = $date->format('Y-m-01');
      $lastDay = $date->format('Y-m-t');
      $count = User::toBase()
        ->select('id')
        ->where('created_at', '>=', $firstDay)
        ->where('created_at', '<=', $lastDay)
        ->get()
        ->count();

      return $count;
    }
}
