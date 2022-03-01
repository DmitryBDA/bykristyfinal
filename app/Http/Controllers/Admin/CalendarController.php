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
    protected $recordService;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
        $this->recordService = new RecordService();
    }

    public function index()
    {
        return view('admin.pages.calendar');
    }

    public function showRecords(): \Illuminate\Http\JsonResponse
    {
        //Получить список всех записей
        $recordList = $this->recordRepository->getAllFromToday();
        //Добавить класс(цвет) в зависимости от статуса записи
        $this->recordService->addAttrClassName($recordList);

        return response()->json($recordList->toArray());
    }

    public function showRecordsWithStatusOne(): \Illuminate\Http\JsonResponse
    {
        $obRecordList = $this->recordRepository->getActiveRecordsForUsers();
        $this->recordService->addAttrClassName($obRecordList);
        return response()->json($obRecordList->toArray());
    }


}
