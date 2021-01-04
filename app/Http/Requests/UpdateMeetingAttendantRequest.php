<?php

namespace App\Http\Requests;

use App\MeetingAttendant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateMeetingAttendantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('meeting_attendant_edit');
    }

    public function rules()
    {
        return [];
    }
}
