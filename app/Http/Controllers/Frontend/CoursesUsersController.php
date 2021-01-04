<?php

namespace App\Http\Controllers\Frontend;

use App\Badge;
use App\CourseSchedule;
use App\CoursesUser;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCoursesUserRequest;
use App\Http\Requests\StoreCoursesUserRequest;
use App\Http\Requests\UpdateCoursesUserRequest;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesUsersController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('courses_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesUsers = CoursesUser::with(['user', 'start_date', 'badges', 'created_by'])->get();

        return view('frontend.coursesUsers.index', compact('coursesUsers'));
    }

    public function create()
    {
        abort_if(Gate::denies('courses_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $start_dates = CourseSchedule::all()->pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.coursesUsers.create', compact('users', 'start_dates'));
    }

    public function store(StoreCoursesUserRequest $request)
    {
        $coursesUser = CoursesUser::create($request->all());

        return redirect()->route('frontend.courses-users.index');
    }

    public function edit(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $start_dates = CourseSchedule::all()->pluck('start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $badges = Badge::all()->pluck('name', 'id');

        $coursesUser->load('user', 'start_date', 'badges', 'created_by');

        return view('frontend.coursesUsers.edit', compact('users', 'start_dates', 'badges', 'coursesUser'));
    }

    public function update(UpdateCoursesUserRequest $request, CoursesUser $coursesUser)
    {
        $coursesUser->update($request->all());
        $coursesUser->badges()->sync($request->input('badges', []));

        return redirect()->route('frontend.courses-users.index');
    }

    public function show(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesUser->load('user', 'start_date', 'badges', 'created_by');

        return view('frontend.coursesUsers.show', compact('coursesUser'));
    }

    public function destroy(CoursesUser $coursesUser)
    {
        abort_if(Gate::denies('courses_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoursesUserRequest $request)
    {
        CoursesUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
