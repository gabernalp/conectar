<?php

namespace App\Http\Requests;

use App\EventsAttendant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEventsAttendantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('events_attendant_create');
    }

    public function rules()
    {
        return [
            'name'          => [
                'string',
                'required',
            ],
            'last_name'     => [
                'string',
                'required',
            ],
            'documenttype'  => [
                'string',
                'required',
            ],
            'document'      => [
                'string',
                'required',
            ],
            'department_id' => [
                'required',
                'integer',
            ],
            'phone'         => [
                'string',
                'nullable',
            ],
            'email'         => [
                'string',
                'nullable',
            ],
        ];
    }
}
