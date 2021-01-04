<?php

namespace App\Http\Requests;

use App\SelfInterestedUser;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSelfInterestedUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('self_interested_user_edit');
    }

    public function rules()
    {
        return [];
    }
}
