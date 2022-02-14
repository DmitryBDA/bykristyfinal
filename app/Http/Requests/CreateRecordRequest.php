<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => 'required|date',
            'timeRecords' => 'required|array|min:1'
        ];
    }

    public function messages()
    {
      return [
        'timeRecords.required' => 'Необходимо добавить минимум одну запись',
      ];
    }
}
