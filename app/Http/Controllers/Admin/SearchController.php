<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\RecordService;
use App\Services\UserService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $userRepository;
    protected $userServices;
    protected $recordRepository;
    protected $recordService;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->userServices = app(UserService::class);
        $this->recordRepository = app(RecordRepository::class);
        $this->recordService = app(RecordService::class);
    }
    public function inputNameAutocomplete(Request $request): \Illuminate\Http\JsonResponse
    {
        $strSearch = $request->str;
        $obUserList = $this->userRepository->searchUsers($strSearch);

        $arNames = $obUserList->isNotEmpty() ? $this->userServices->arrPhoneName($obUserList) : [] ;

        return response()->json($arNames);
    }

    public function getActiveListsRecords(Request $request)
    {
        $strSearch = $request->strSearch;
        //Получить список записей
        $obRecordList = $this->recordRepository->getActiveList($strSearch);
        //Сформировать массив данных из $obRecordList
        $arRecordList = $this->recordService->generateArrayRecords($obRecordList);

        return response()->json($arRecordList);
    }
}
