<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
  public function index(UserRepository $userRepository)
  {
    $obUserList = $userRepository->getAll();
    return view('admin.pages.client', compact('obUserList'));
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
}
