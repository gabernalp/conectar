<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyMeetingAttendantRequest;
use App\Http\Requests\StoreMeetingAttendantRequest;
use App\Http\Requests\UpdateMeetingAttendantRequest;
use App\Meeting;
use App\MeetingAttendant;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MeetingAttendantsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('meeting_attendant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingAttendants = MeetingAttendant::with(['meeting', 'user'])->get();

        return view('frontend.meetingAttendants.index', compact('meetingAttendants'));
    }

    public function create()
    {
        abort_if(Gate::denies('meeting_attendant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetings = Meeting::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.meetingAttendants.create', compact('meetings', 'users'));
    }

    public function store(StoreMeetingAttendantRequest $request)
    {
        $meetingAttendant = MeetingAttendant::create($request->all());

        return redirect()->route('frontend.meeting-attendants.index');
    }

    public function edit(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetings = Meeting::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $meetingAttendant->load('meeting', 'user');

        return view('frontend.meetingAttendants.edit', compact('meetings', 'users', 'meetingAttendant'));
    }

    public function update(UpdateMeetingAttendantRequest $request, MeetingAttendant $meetingAttendant)
    {
        $meetingAttendant->update($request->all());

        return redirect()->route('frontend.meeting-attendants.index');
    }

    public function show(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingAttendant->load('meeting', 'user');

        return view('frontend.meetingAttendants.show', compact('meetingAttendant'));
    }

    public function destroy(MeetingAttendant $meetingAttendant)
    {
        abort_if(Gate::denies('meeting_attendant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $meetingAttendant->delete();

        return back();
    }

    public function massDestroy(MassDestroyMeetingAttendantRequest $request)
    {
        MeetingAttendant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
