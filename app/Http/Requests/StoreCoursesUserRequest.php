<?php

namespace App\Http\Requests;

use App\CoursesUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCoursesUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('courses_user_create');
    }

    public function rules()
    {
        return [
            'course_name'   => [
                'string',
                'required',
            ],
            'start_date_id' => [
                'required',
                'integer',
            ],
            'challenges'    => [
                'string',
                'required',
            ],
        ];
    }
}
