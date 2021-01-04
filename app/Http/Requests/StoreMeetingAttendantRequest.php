<?php

namespace App\Http\Requests;

use App\MeetingAttendant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreMeetingAttendantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('meeting_attendant_create');
    }

    public function rules()
    {
        return [];
    }
}
