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

}
