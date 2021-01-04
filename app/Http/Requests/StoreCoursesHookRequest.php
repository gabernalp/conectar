<?php

namespace App\Http\Requests;

use App\CoursesHook;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCoursesHookRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('courses_hook_create');
    }

    public function rules()
    {
        return [
            'name'   => [
                'string',
                'required',
            ],
            'link'   => [
                'string',
                'nullable',
            ],
            'rols.*' => [
                'integer',
            ],
            'rols'   => [
                'array',
            ],
        ];
    }
}
