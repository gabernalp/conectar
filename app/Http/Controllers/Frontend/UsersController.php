<?php

namespace App\Http\Controllers\Frontend;

use App\City;
use App\Department;
use App\Device;
use App\DocumentType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Operator;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::with(['documenttype', 'department', 'city', 'devices', 'roles', 'operator'])->get();

        return view('frontend.users.index', compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documenttypes = DocumentType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $devices = Device::all()->pluck('name', 'id');

        $roles = Role::all()->pluck('title', 'id');

        $operators = Operator::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.users.create', compact('documenttypes', 'departments', 'cities', 'devices', 'roles', 'operators'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->devices()->sync($request->input('devices', []));
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('frontend.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $documenttypes = DocumentType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $departments = Department::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $devices = Device::all()->pluck('name', 'id');

        $roles = Role::all()->pluck('title', 'id');

        $operators = Operator::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $user->load('documenttype', 'department', 'city', 'devices', 'roles', 'operator');

        return view('frontend.users.edit', compact('documenttypes', 'departments', 'cities', 'devices', 'roles', 'operators', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->devices()->sync($request->input('devices', []));
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('frontend.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('documenttype', 'department', 'city', 'devices', 'roles', 'operator', 'userFeedbacksUsers', 'userCoursesUsers', 'userChallengesUsers', 'userMeetings', 'userUserChainBlocks', 'userUserAlerts', 'tutorsCourseSchedules');

        return view('frontend.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
