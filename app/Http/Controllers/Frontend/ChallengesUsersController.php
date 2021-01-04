<?php

namespace App\Http\Controllers\Frontend;

use App\Challenge;
use App\ChallengesUser;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyChallengesUserRequest;
use App\Http\Requests\StoreChallengesUserRequest;
use App\Http\Requests\UpdateChallengesUserRequest;
use App\ReferenceType;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChallengesUsersController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('challenges_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUsers = ChallengesUser::with(['challenge', 'user', 'referencetype'])->get();

        $challenges = Challenge::get();

        $users = User::get();

        $reference_types = ReferenceType::get();

        return view('frontend.challengesUsers.index', compact('challengesUsers', 'challenges', 'users', 'reference_types'));
    }

    public function create()
    {
        abort_if(Gate::denies('challenges_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenges = Challenge::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.challengesUsers.create', compact('challenges', 'users'));
    }

    public function store(StoreChallengesUserRequest $request)
    {
        $challengesUser = ChallengesUser::create($request->all());

        return redirect()->route('frontend.challenges-users.index');
    }

    public function edit(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenges = Challenge::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $challengesUser->load('challenge', 'user', 'referencetype');

        return view('frontend.challengesUsers.edit', compact('challenges', 'users', 'challengesUser'));
    }

    public function update(UpdateChallengesUserRequest $request, ChallengesUser $challengesUser)
    {
        $challengesUser->update($request->all());

        return redirect()->route('frontend.challenges-users.index');
    }

    public function show(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUser->load('challenge', 'user', 'referencetype');

        return view('frontend.challengesUsers.show', compact('challengesUser'));
    }

    public function destroy(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyChallengesUserRequest $request)
    {
        ChallengesUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
