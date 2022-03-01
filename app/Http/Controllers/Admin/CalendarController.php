<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\RecordService;
use App\Services\TelegramService;

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

    public function index()
    {
        return view('admin.pages.calendar');
    }

    public function showRecords()
    {
        //Получить список всех записей
        $recordList = $this->recordRepository->getAllFromToday();
        //Добавить класс(цвет) в зависимости от статуса записи
        $this->recordService->addAttrClassName($recordList);

        return response()->json($recordList->toArray());
    }

    public function showRecordsForUsers()
    {

        $obRecordList = $this->recordRepository->getActiveRecordsForUsers();
        $obRecordList = $this->recordService->addAttrClassName($obRecordList);
        return response()->json($obRecordList);
    }


}
