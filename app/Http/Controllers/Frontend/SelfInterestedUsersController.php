<?php

namespace App\Http\Controllers\Frontend;

use App\CoursesHook;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySelfInterestedUserRequest;
use App\Http\Requests\StoreSelfInterestedUserRequest;
use App\Http\Requests\UpdateSelfInterestedUserRequest;
use App\SelfInterestedUser;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SelfInterestedUsersController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('self_interested_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfInterestedUsers = SelfInterestedUser::with(['user', 'coursehook'])->get();

        return view('frontend.selfInterestedUsers.index', compact('selfInterestedUsers'));
    }

    public function create()
    {
        abort_if(Gate::denies('self_interested_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursehooks = CoursesHook::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.selfInterestedUsers.create', compact('users', 'coursehooks'));
    }

    public function store(StoreSelfInterestedUserRequest $request)
    {
        $selfInterestedUser = SelfInterestedUser::create($request->all());

        return redirect()->route('frontend.self-interested-users.index');
    }

    public function edit(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursehooks = CoursesHook::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $selfInterestedUser->load('user', 'coursehook');

        return view('frontend.selfInterestedUsers.edit', compact('users', 'coursehooks', 'selfInterestedUser'));
    }

    public function update(UpdateSelfInterestedUserRequest $request, SelfInterestedUser $selfInterestedUser)
    {
        $selfInterestedUser->update($request->all());

        return redirect()->route('frontend.self-interested-users.index');
    }

    public function show(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfInterestedUser->load('user', 'coursehook');

        return view('frontend.selfInterestedUsers.show', compact('selfInterestedUser'));
    }

    public function destroy(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfInterestedUser->delete();

        return back();
    }

    public function massDestroy(MassDestroySelfInterestedUserRequest $request)
    {
        SelfInterestedUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
