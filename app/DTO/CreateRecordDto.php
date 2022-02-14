<?php

namespace App\DTO;

use App\Http\Requests\CreateRecordRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateRecordDto extends DataTransferObject
{
  public string $date;

  public array $timeRecords;

  public static function fromRequest(CreateRecordRequest $request):self
  {
    $data = $request->validated();
    return new self([
      'date' => $data['date'],
      'timeRecords' => $data['timeRecords']
    ]);
  }
}
