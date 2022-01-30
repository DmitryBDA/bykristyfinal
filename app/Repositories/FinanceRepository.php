<?php

namespace App\Repositories;

use App\Models\Record as Model;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Carbon;

class FinanceRepository extends CoreRepository
{


    protected function getModelClass()
    {
        return Model::class;
    }

    public function getRecordListToday()
    {
        $today = new DateTime('now', new DateTimeZone('Asia/Irkutsk'));

        $events = $this->startCondition()
            ->with('service')
            ->whereDate('start', '<=', $today)
            ->where('status', '!=', 1)
            ->where('start', '>=', $today->format('Y-m-01'))
            ->orderBy('start')
            ->get();

        return $events;
    }

    public function getSumForMonth()
    {
        $firstDay = date('Y-m-01');
        $lastDay = date('Y-m-t');


        $events = $this->startCondition()
            ->with('service')
            ->where('start', '>=', $firstDay)
            ->where('status', '!=', 1)
            ->where('start', '<=', $lastDay)
            ->get();

        $arrServices = [];
        $sumOnTekDay = 0;
        foreach ($events as $event) {
            if ($event->service) {
                if (array_key_exists($event->service->name, $arrServices)) {

                    $arrServices[$event->service->name] += $event->service->price;
                } else {
                    $arrServices[$event->service->name] = $event->service->price;
                }

                $sumOnTekDay += $event->service->price;

            }
        }

        return $arrServices;
    }

}
