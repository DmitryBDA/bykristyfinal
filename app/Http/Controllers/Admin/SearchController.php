<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\UserService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $userRepository;
    protected $userServices;

    public function __construct()
    {
        $this->userRepository = app(UserRepository::class);
        $this->userServices = app(UserService::class);
    }
    public function inputNameAutocomplete(Request $request): \Illuminate\Http\JsonResponse
    {
        $strSearch = $request->str;
        $obUserList = $this->userRepository->searchUsers($strSearch);

        $arNames = $obUserList->isNotEmpty() ? $this->userServices->arrPhoneName($obUserList) : [] ;

        return response()->json($arNames);
    }
}
