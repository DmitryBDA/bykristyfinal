<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\FinanceRepository;
use App\Services\FinanceService;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected $financeRepository;
    protected $financeService;


    public function __construct()
    {
        $this->financeRepository = app(FinanceRepository::class);
        $this->financeService = app(FinanceService::class);
    }

    public function index()
    {

      $obRecordList = $this->financeRepository->getRecordListToday();
      $dataOnTekDay = $this->financeService->sumByTypeService($obRecordList);

        $sumForMonth = $this->financeRepository->getSumForMonth();

        $dataOnMonth = [];
        foreach ($sumForMonth as $key => $value) {
            $dataOnMonth['arNameServices'][] = $key;
            $dataOnMonth['arPriceService'][] = $value;
        }
        $dataOnMonth['arSum'] = array_sum($dataOnMonth['arPriceService']);

        return view('admin.pages.finance', compact('dataOnTekDay', 'dataOnMonth'));
    }
}
