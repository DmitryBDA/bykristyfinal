<?php

namespace App\Repositories;

use App\Models\Record as Model;
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

}
