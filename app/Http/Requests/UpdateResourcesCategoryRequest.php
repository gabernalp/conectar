<?php

namespace App\Http\Requests;

use App\ResourcesCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateResourcesCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('resources_category_edit');
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
