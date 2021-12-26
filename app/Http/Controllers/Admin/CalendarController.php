<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CalendarController extends Controller
{
    public function index(){
        return view('admin.pages.calendar');
    }

    public function showRecords()
    {
        header('Content-type: application/json');

        $tekDate = Carbon::today()->format('Y-m-d');

        $data = Record::whereDate('start', '>=', $tekDate)
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'end', 'status', 'all_day']);

        foreach ($data as $elem) {
            switch ($elem->status) {
                case 1:
                    $elem->setAttr('className', "greenEvent");
                    break;
                case 2:
                    $elem->setAttr('className', "yellowEvent");
                    break;
                case 3:
                    $elem->setAttr('className', "redEvent");
                    break;
                case 4:
                    $elem->setAttr('className', "greyEvent");
                    break;
            }
        }

        return response()->json($data);
    }
}
