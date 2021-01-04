<?php

namespace App\Http\Requests;

use App\Device;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDeviceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('device_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
