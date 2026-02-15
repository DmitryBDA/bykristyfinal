<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
  public function index(UserRepository $userRepository)
  {
    $obUserList = $userRepository->getAll();
    return view('admin.pages.client', compact('obUserList'));
  }

  public function getData(Request $request, UserRepository $userRepository): \Illuminate\Http\JsonResponse
  {
    $phone = str_replace(['(', ')', '-', ' '], '', $request->get('phone'));
    $phone = substr($phone, 1);
    if ($phone) {
      $dataUser = $userRepository->getByPhone($phone);
    }

    return response()->json(['data' => [
      'name' => $dataUser?->name,
      'surname' => $dataUser?->surname,
    ]]);
  }

  public function show($userId, UserRepository $userRepository){

    $obUser = $userRepository->getById($userId);

    return view('admin.pages.client-page', compact('obUser'));
  }

  public function update($userId, Request $request, UserRepository $userRepository)
  {
    $data['name'] = $request->get('name');
    $data['surname'] = $request->get('surname');
    $data['phone'] = str_replace(['(', ')', '-', ' '], '', $request->get('phone'));

    $obUser = $userRepository->getById($userId);
    $result = $obUser->update($data);

    if($result) {
      return redirect()
        ->route('admin.client.show', $obUser->id)
        ->with(['success' => 'Успешно сохранено']);
    }
  }

  public function sendNotification($userId,
                                   RecordRepository $recordRepository,
                                   TelegramService $telegramService,
                                   UserRepository $userRepository)
  {
    $obRecordList = $recordRepository->getRecordsByUserId($userId);
    if($obRecordList->isNotEmpty()){
      foreach ($obRecordList as $obRecord){
        $obUser = $userRepository->getById($userId);
        $telegramService->sendNotificationNewRecord($obUser, $obRecord);
      }
      return redirect()
        ->route('admin.client.show', $obUser->id)
        ->with(['success' => 'Уведомления отправлены']);
    }
  }
}
