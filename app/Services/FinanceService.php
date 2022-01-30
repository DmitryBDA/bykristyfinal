<?php

namespace App\Services;

class FinanceService
{
  public function sumByTypeService($obRecordList)
  {

    $arrServices = [];
    $sumOnTekDay = 0;
    foreach ($obRecordList as $event) {
      if ($event->service) {
        if (array_key_exists($event->service->name, $arrServices)) {
          $arrServices[$event->service->name] += $event->service->price;
        } else {
          $arrServices[$event->service->name] = $event->service->price;
        }

        $sumOnTekDay += $event->service->price;

      }
    }

    $dataOnTekDay = [];
    foreach ($arrServices as $key => $value) {
      $dataOnTekDay['arNameServices'][] = $key;
      $dataOnTekDay['arPriceService'][] = $value;
    }
    $dataOnTekDay['arSum'] = array_sum($dataOnTekDay['arPriceService']);

    return $dataOnTekDay;
  }
}
