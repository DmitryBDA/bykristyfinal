<?php

namespace App\Services;

use App\Presenters\Record\RecordPresenter;
use Illuminate\Support\Carbon;

class RecordService
{
    public function addAttrClassName($obRecordList)
    {
        foreach ($obRecordList as $obRecord) {
            switch ($obRecord->status) {
                case 1:
                    $obRecord->setAttr('className', "greenEvent");
                    break;
                case 2:
                    $obRecord->setAttr('className', "yellowEvent");
                    break;
                case 3:
                    $obRecord->setAttr('className', "redEvent");
                    break;
                case 4:
                    $obRecord->setAttr('className', "greyEvent");
                    break;
            }
        }
        return $obRecordList;
    }

    //Формирование массива в нужном формате из списка записей
    public function generateArrayRecords($obRecordList){
        $arRecordList = [];

        $index = 0;
        if ($obRecordList->isNotEmpty()) {

            $nowDate = Carbon::parse($obRecordList->first()->start)->format('d.m.Y');

            foreach ($obRecordList as $obRecord) {
                $date = Carbon::parse($obRecord->start)->format('d.m.Y');
                if ($nowDate !== $date) {
                    $index = 0;
                }

                $arRecordList[$date][$index]['time'] = Carbon::parse($obRecord->start)->format('H:s');
                $arRecordList[$date][$index]['phone'] = $obRecord->user->phone;
                $arRecordList[$date][$index]['name'] = $obRecord->user->surname . ' ' . $obRecord->user->name;

                $nowDate = Carbon::create($obRecord->start)->format('d.m.Y');
                $index++;
            }
        }

        $arRecordListReady = [];
        $index = 0;
        foreach ($arRecordList as $key => $item) {
            $arRecordListReady[$index]['date'] = Carbon::create($key)->format('d.m.Y');
            $arRecordListReady[$index]['value'] = $item;

            $index++;
        }
        return $arRecordListReady;
    }

    public function modArrOtherTime($obRecordList){
      $result = [];
      $i = 0;
      foreach ($obRecordList as $obRecord){
        $record = new RecordPresenter($obRecord);
        $result[$i]['time'] = $record->time();
        $result[$i]['date'] = $record->startDate();
        $i++;
      }
      return $result;
    }
}
