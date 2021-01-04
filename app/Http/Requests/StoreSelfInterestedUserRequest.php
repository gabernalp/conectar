<?php

namespace App\Http\Requests;

use App\SelfInterestedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSelfInterestedUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('self_interested_user_create');
    }

    public function rules()
    {
        return [];
    }
}
