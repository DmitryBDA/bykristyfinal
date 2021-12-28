<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use App\Repositories\RecordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    protected $recordRepository;
    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
    }

    public function index(){
        return view('admin.pages.calendar');
    }

    public function showRecords()
    {

        $recordList = $this->recordRepository->getActiveRecords();
        return response()->json($recordList);
    }

    public function createRecords(Request $request)
    {
        $this->recordRepository->addRecords($request);
    }
}
