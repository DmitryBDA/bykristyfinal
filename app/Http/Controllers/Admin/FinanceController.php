<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\FinanceRepository;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    protected $financeRepository;


    public function __construct()
    {
        $this->financeRepository = app(FinanceRepository::class);
    }

    public function index()
    {

        $sumOnTekDay = $this->financeRepository->getSumOnToday();
        $dataOnTekDay = [];
        foreach ($sumOnTekDay as $key => $value) {
            $dataOnTekDay['arNameServices'][] = $key;
            $dataOnTekDay['arPriceService'][] = $value;
        }
        $dataOnTekDay['arSum'] = array_sum($dataOnTekDay['arPriceService']);


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
