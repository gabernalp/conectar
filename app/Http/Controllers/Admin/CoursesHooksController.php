<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class CoursesHooksController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('courses_hook_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CoursesHook::with(['rols'])->select(sprintf('%s.*', (new CoursesHook)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'courses_hook_show';
                $editGate      = 'courses_hook_edit';
                $deleteGate    = 'courses_hook_delete';
                $crudRoutePart = 'courses-hooks';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });
            $table->editColumn('requirements', function ($row) {
                return $row->requirements ? $row->requirements : "";
            });
            $table->editColumn('link', function ($row) {
                return $row->link ? $row->link : "";
            });
            $table->editColumn('priorized', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->priorized ? 'checked' : null) . '>';
            });
            $table->editColumn('rol', function ($row) {
                $labels = [];

                foreach ($row->rols as $rol) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $rol->title);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('educational_level', function ($row) {
                return $row->educational_level ? CoursesHook::EDUCATIONAL_LEVEL_SELECT[$row->educational_level] : '';
            });
            $table->editColumn('growinghook', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->growinghook ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'priorized', 'rol', 'growinghook']);

            return $table->make(true);
        }

        return view('admin.coursesHooks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('courses_hook_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rols = Role::all()->pluck('title', 'id');

        return view('admin.coursesHooks.create', compact('rols'));
    }

    public function store(StoreCoursesHookRequest $request)
    {
        $coursesHook = CoursesHook::create($request->all());
        $coursesHook->rols()->sync($request->input('rols', []));

        return redirect()->route('admin.courses-hooks.index');
    }

    public function edit(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rols = Role::all()->pluck('title', 'id');

        $coursesHook->load('rols');

        return view('admin.coursesHooks.edit', compact('rols', 'coursesHook'));
    }

    public function update(UpdateCoursesHookRequest $request, CoursesHook $coursesHook)
    {
        $coursesHook->update($request->all());
        $coursesHook->rols()->sync($request->input('rols', []));

        return redirect()->route('admin.courses-hooks.index');
    }

    public function show(CoursesHook $coursesHook)
    {
        abort_if(Gate::denies('courses_hook_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coursesHook->load('rols', 'courseshooksCourses');

        return view('admin.coursesHooks.show', compact('coursesHook'));
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
