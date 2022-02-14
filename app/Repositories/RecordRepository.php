<?php

namespace App\Repositories;

use App\DTO\CreateRecordDto;
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
    public function getAllFromToday()
    {
        $tekDate = Carbon::today()->format('Y-m-d');
        //Получить список записей от сегоднящнего дня
        $recordList = $this->startCondition()
            ->whereDate('start', '>=', $tekDate)
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'status']);

        return $recordList;
    }

    public function getActiveRecordsForUsers()
    {
        $tekDate = Carbon::today()->format('Y-m-d');
        //Получить список записей
        $obRecordList = $this->startCondition()
            ->whereDate('start', '>', $tekDate)
            ->where('status', 1)
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'status']);

        return $obRecordList;
    }

    public function addRecords(CreateRecordDto $dto)
    {

        $arrRecords = $dto->timeRecords;

        foreach ($arrRecords as $record) {

            $date = $dto->date . ' ' . $record['value'];
            $arrData = [
                'title' => $record['title'] ? $record['title'] : '',
                'start' => $date,
                'end' => $date,
                'status' => $record['status']
            ];
            $this->startCondition()::create($arrData);
        }
    }

    public function cancelRecord($recordId)
    {
        $obRecord = $this->startCondition()
            ->find($recordId);

        $result = $obRecord->update([
            'status' => 1,
            'user_id' => null,
            'service_id' => null,
        ]);
        return $result;
    }

    public function confirmRecord($recordId)
    {
        $obRecord = $this->startCondition()->find($recordId);

        $result = $obRecord->update(['status' => 3]);

        return $result;
    }

    public function deleteRecord($recordId)
    {
        $result = $this->startCondition()
            ->find($recordId)
            ->delete();

        return $result;
    }

    public function getById($id)
    {

        $record = $this->startCondition()
            ->where('id', $id)
            ->with('user')
            ->first();

        return $record;
    }

    public function getActiveList($strSearch)
    {
        $tekDate = Carbon::today()->format('Y-m-d');
        //Получить список записей
        $obRecordList = $this->startCondition()
            ->whereDate('start', '>=', $tekDate)
            ->whereIn('status', [2, 3])
            ->whereHas('user', $filter = function ($query) use ($strSearch) {
                $query->where('name', 'LIKE', "%$strSearch%")
                    ->orWhere('surname', 'LIKE', "%$strSearch%");
            })
            ->with('user')
            ->orderBy('start', 'asc')
            ->get();

        return $obRecordList;
    }

}
