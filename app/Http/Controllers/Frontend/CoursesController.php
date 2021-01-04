<?php

namespace App\Http\Controllers\Frontend;

use App\BackgroundProcess;
use App\Course;
use App\CoursesHook;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Operator;
use App\ReferenceObject;
use App\Role;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::with(['associated_processes', 'roles', 'focalizacion_territorials', 'operators', 'references', 'courseshooks'])->get();

        $background_processes = BackgroundProcess::get();

        $roles = Role::get();

        $departments = Department::get();

        $operators = Operator::get();

        $reference_objects = ReferenceObject::get();

        $courses_hooks = CoursesHook::get();

        return view('frontend.courses.index', compact('courses', 'background_processes', 'roles', 'departments', 'operators', 'reference_objects', 'courses_hooks'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $associated_processes = BackgroundProcess::all()->pluck('name', 'id');

        $roles = Role::all()->pluck('title', 'id');

        $focalizacion_territorials = Department::all()->pluck('name', 'id');

        $operators = Operator::all()->pluck('name', 'id');

        $references = ReferenceObject::all()->pluck('title', 'id');

        $courseshooks = CoursesHook::all()->pluck('name', 'id');

        return view('frontend.courses.create', compact('associated_processes', 'roles', 'focalizacion_territorials', 'operators', 'references', 'courseshooks'));
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());
        $course->associated_processes()->sync($request->input('associated_processes', []));
        $course->roles()->sync($request->input('roles', []));
        $course->focalizacion_territorials()->sync($request->input('focalizacion_territorials', []));
        $course->operators()->sync($request->input('operators', []));
        $course->references()->sync($request->input('references', []));
        $course->courseshooks()->sync($request->input('courseshooks', []));

        return redirect()->route('frontend.courses.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $associated_processes = BackgroundProcess::all()->pluck('name', 'id');

        $roles = Role::all()->pluck('title', 'id');

        $focalizacion_territorials = Department::all()->pluck('name', 'id');

        $operators = Operator::all()->pluck('name', 'id');

        $references = ReferenceObject::all()->pluck('title', 'id');

        $courseshooks = CoursesHook::all()->pluck('name', 'id');

        $course->load('associated_processes', 'roles', 'focalizacion_territorials', 'operators', 'references', 'courseshooks');

        return view('frontend.courses.edit', compact('associated_processes', 'roles', 'focalizacion_territorials', 'operators', 'references', 'courseshooks', 'course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());
        $course->associated_processes()->sync($request->input('associated_processes', []));
        $course->roles()->sync($request->input('roles', []));
        $course->focalizacion_territorials()->sync($request->input('focalizacion_territorials', []));
        $course->operators()->sync($request->input('operators', []));
        $course->references()->sync($request->input('references', []));
        $course->courseshooks()->sync($request->input('courseshooks', []));

        return redirect()->route('frontend.courses.index');
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->load('associated_processes', 'roles', 'focalizacion_territorials', 'operators', 'references', 'courseshooks', 'coursesChallenges');

        return view('frontend.courses.show', compact('course'));
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
