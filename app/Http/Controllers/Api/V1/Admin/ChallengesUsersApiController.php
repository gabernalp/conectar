<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\ChallengesUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChallengesUserRequest;
use App\Http\Requests\UpdateChallengesUserRequest;
use App\Http\Resources\Admin\ChallengesUserResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChallengesUsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('challenges_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChallengesUserResource(ChallengesUser::with(['challenge', 'user', 'referencetype'])->get());
    }

    public function store(StoreChallengesUserRequest $request)
    {
        $challengesUser = ChallengesUser::create($request->all());

        return (new ChallengesUserResource($challengesUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ChallengesUserResource($challengesUser->load(['challenge', 'user', 'referencetype']));
    }

    public function update(UpdateChallengesUserRequest $request, ChallengesUser $challengesUser)
    {
        $challengesUser->update($request->all());

        return (new ChallengesUserResource($challengesUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ChallengesUser $challengesUser)
    {
        abort_if(Gate::denies('challenges_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challengesUser->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
