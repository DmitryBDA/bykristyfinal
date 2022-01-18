<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Presenters\Record\RecordPresenter;
use App\Presenters\User\UserPresenter;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    protected $recordRepository;
    protected $userRepository;
    protected $recordServices;
    protected $telegramService;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
        $this->userRepository = app(UserRepository::class);
        $this->telegramService = new TelegramService();
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

    public function addUser(Request $request){
        //Получить все отправленные данные
        $data = $request->all();
        //Получить запись по id
        $obRecord = $this->recordRepository->getById($data['recordId']);
        //Поиск пользователя по телефону
        $user = $this->userRepository->findUserByPhone($data['phone']);
        //Если пользователь не найден
        if (!$user) {
            //Создать нового пользователя
            $user = $this->userRepository->createUser($request);
        }
        //Добавть данные из формы к записи
        $obRecord->update([
            'user_id' => $user->id,
            'status' => 3,
            'service_id' => $data['serviceId']
        ]);
        //Отправить уведомление о новой записи
        $this->telegramService->sendNotificationNewRecord($user, $obRecord);

        return response()->json($obRecord);
    }
}
