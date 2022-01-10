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
}
