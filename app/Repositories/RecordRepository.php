<?php

namespace App\Repositories;

use App\Models\Record as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RecordRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return mixed
     */
    public function getActiveRecords()
    {
        $tekDate = Carbon::today()->format('Y-m-d');
        //Получить список записей
        $recordList = $this->startCondition()
            ->whereDate('start', '>=', $tekDate)
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'status']);

        //Добавить записям класс в зависимости от статуса
        foreach ($recordList as $elem) {
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

        return $recordList;
    }

    public function addRecords(Request $request){

        $data = $request->date;
        $arrRecords = $request->timeRecords;

        foreach ($arrRecords as $record) {

            $date = $request->date . ' ' . $record['value'];
            $arrData = [
                'title' => $record['title'] ? $record['title'] : '',
                'start' => $date,
                'end' => $date,
                'status' => $record['status']
            ];
            $event = $this->startCondition()::create($arrData);
        }
    }

    public function getListActiveRecords()
    {
        $tekDate = Carbon::today()->format('Y-m-d');
        //Получить список записей
        $recordList = $this->startCondition()
            ->whereDate('start', '>=', $tekDate)
            ->where('status', 3)
            ->orWhere('status', 2)
            ->with('user')
            ->orderBy('start', 'asc')
            ->get();

        $arEventList = [];

        $index = 0;
        if($recordList->isNotEmpty()){

            $nowDate = Carbon::create($recordList->first()->start)->format('d.m.Y');

            foreach ($recordList as $event){
                $date = Carbon::create($event->start)->format('d.m.Y');
                if($nowDate !== $date){
                    $index = 0;
                }

                $arEventList[$date][$index]['time'] = Carbon::create($event->start)->format('H:s');
                $arEventList[$date][$index]['phone'] = $event->user->phone;
                $arEventList[$date][$index]['name'] = $event->user->surname . ' ' .$event->user->name ;

                $nowDate = Carbon::create($event->start)->format('d.m.Y');
                $index++;
            }

            $eventList = $arEventList;
        }

        $recordList = [];
        $index = 0;
        foreach ($arEventList as $key => $item){
            $recordList[$index]['date'] = Carbon::create($key)->format('d.m.Y');
            $recordList[$index]['value'] = $item;

            $index++;
        }


        return $recordList;
    }

}
