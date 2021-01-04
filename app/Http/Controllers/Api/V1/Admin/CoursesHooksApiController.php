<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CoursesHook;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoursesHookRequest;
use App\Http\Requests\UpdateCoursesHookRequest;
use App\Http\Resources\Admin\CoursesHookResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesHooksApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('courses_hook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoursesHookResource(CoursesHook::with(['rols'])->get());
    }

    public function store(StoreCoursesHookRequest $request)
    {
        $coursesHook = CoursesHook::create($request->all());
        $coursesHook->rols()->sync($request->input('rols', []));

        return (new CoursesHookResource($coursesHook))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CoursesHookResource($coursesHook->load(['rols']));
    }

    public function update(UpdateCoursesHookRequest $request, CoursesHook $coursesHook)
    {
        $coursesHook->update($request->all());
        $coursesHook->rols()->sync($request->input('rols', []));

        return (new CoursesHookResource($coursesHook))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
