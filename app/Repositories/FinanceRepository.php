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

    public function getSumOnToday()
    {
        $today = new DateTime('now', new DateTimeZone('Asia/Irkutsk'));


        $tekDate = $today->format('Y-m-d');
        $tekTime = $today->format('H');
        $firstDay = date('Y-m-01');
        $lastDay = date('Y-m-t');


        $events = $this->startCondition()
            ->with('service')
            ->where('start', '<', $tekDate)
            ->where('status', '!=', 1)
            ->where('start', '>=', $firstDay)
            ->get();

        $event = $this->startCondition()
            ->with('service')
            ->where('start', $tekDate)
            ->where('status', '!=', 1)
            ->get();

        $events = $events->merge($event);
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
