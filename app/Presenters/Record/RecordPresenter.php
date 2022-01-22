<?php

namespace App\Presenters\Record;

use App\Presenters\Presenter;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

class RecordPresenter extends Presenter
{
    public function startDate()
    {
        return Carbon::create($this->model->start)->format('d.m.Y');
    }

    public function dayWeek()
    {
        return Date::parse($this->model->start)->format('l');
    }

    public function time()
    {
        return Carbon::create($this->model->start)->format('H:s');
    }
}
