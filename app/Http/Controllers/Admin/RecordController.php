<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\RecordRepository;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    protected $recordRepository;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
    }

    public function create(Request $request){
        $data = $request->all();
        $this->recordRepository->addRecords($data);
    }
}
