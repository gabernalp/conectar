<?php

namespace App\Http\Controllers\Frontend;

use App\City;
use App\Department;
use App\EventsAttendant;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEventsAttendantRequest;
use App\Http\Requests\StoreEventsAttendantRequest;
use App\Http\Requests\UpdateEventsAttendantRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsAttendantsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('events_attendant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsAttendants = EventsAttendant::with(['department', 'city'])->get();

        return view('frontend.eventsAttendants.index', compact('eventsAttendants'));
    }

    public function create()
    {
        abort_if(Gate::denies('events_attendant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.eventsAttendants.create', compact('departments', 'cities'));
    }

    public function store(StoreEventsAttendantRequest $request)
    {
        $eventsAttendant = EventsAttendant::create($request->all());

        return redirect()->route('frontend.events-attendants.index');
    }

    public function edit(EventsAttendant $eventsAttendant)
    {
        abort_if(Gate::denies('events_attendant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $eventsAttendant->load('department', 'city');

        return view('frontend.eventsAttendants.edit', compact('departments', 'cities', 'eventsAttendant'));
    }

    public function update(UpdateEventsAttendantRequest $request, EventsAttendant $eventsAttendant)
    {
        $eventsAttendant->update($request->all());

        return redirect()->route('frontend.events-attendants.index');
    }

    public function show(EventsAttendant $eventsAttendant)
    {
        abort_if(Gate::denies('events_attendant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsAttendant->load('department', 'city');

        return view('frontend.eventsAttendants.show', compact('eventsAttendant'));
    }

    public function destroy(EventsAttendant $eventsAttendant)
    {
        abort_if(Gate::denies('events_attendant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $eventsAttendant->delete();

        return back();
    }

    public function massDestroy(MassDestroyEventsAttendantRequest $request)
    {
        EventsAttendant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
