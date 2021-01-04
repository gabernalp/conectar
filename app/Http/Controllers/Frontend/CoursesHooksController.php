<?php

namespace App\Http\Controllers\Frontend;

use App\CoursesHook;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCoursesHookRequest;
use App\Http\Requests\StoreCoursesHookRequest;
use App\Http\Requests\UpdateCoursesHookRequest;
use App\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesHooksController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('courses_hook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHooks = CoursesHook::with(['rols'])->get();

        return view('frontend.coursesHooks.index', compact('coursesHooks'));
    }

    public function create()
    {
        abort_if(Gate::denies('courses_hook_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rols = Role::all()->pluck('title', 'id');

        return view('frontend.coursesHooks.create', compact('rols'));
    }

    public function store(StoreCoursesHookRequest $request)
    {
        $coursesHook = CoursesHook::create($request->all());
        $coursesHook->rols()->sync($request->input('rols', []));

        return redirect()->route('frontend.courses-hooks.index');
    }

    public function edit(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rols = Role::all()->pluck('title', 'id');

        $coursesHook->load('rols');

        return view('frontend.coursesHooks.edit', compact('rols', 'coursesHook'));
    }

    public function update(UpdateCoursesHookRequest $request, CoursesHook $coursesHook)
    {
        $coursesHook->update($request->all());
        $coursesHook->rols()->sync($request->input('rols', []));

        return redirect()->route('frontend.courses-hooks.index');
    }

    public function show(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->load('rols', 'courseshooksCourses');

        return view('frontend.coursesHooks.show', compact('coursesHook'));
    }

    public function destroy(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->delete();

        return back();
    }

    public function massDestroy(MassDestroyCoursesHookRequest $request)
    {
        CoursesHook::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
