<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class SelfInterestedUsersController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('self_interested_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SelfInterestedUser::with(['user', 'coursehook'])->select(sprintf('%s.*', (new SelfInterestedUser)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'self_interested_user_show';
                $editGate      = 'self_interested_user_edit';
                $deleteGate    = 'self_interested_user_delete';
                $crudRoutePart = 'self-interested-users';

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
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->editColumn('user.last_name', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->last_name) : '';
            });
            $table->editColumn('user.phone', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->phone) : '';
            });
            $table->editColumn('user.academic_background', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->academic_background) : '';
            });
            $table->editColumn('user.document', function ($row) {
                return $row->user ? (is_string($row->user) ? $row->user : $row->user->document) : '';
            });
            $table->addColumn('coursehook_name', function ($row) {
                return $row->coursehook ? $row->coursehook->name : '';
            });

            $table->editColumn('coursehook.educational_level', function ($row) {
                return $row->coursehook ? (is_string($row->coursehook) ? $row->coursehook : $row->coursehook->educational_level) : '';
            });
            $table->editColumn('contact', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->contact ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'coursehook', 'contact']);

            return $table->make(true);
        }

        return view('admin.selfInterestedUsers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('self_interested_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursehooks = CoursesHook::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.selfInterestedUsers.create', compact('users', 'coursehooks'));
    }

    public function store(StoreSelfInterestedUserRequest $request)
    {
        $selfInterestedUser = SelfInterestedUser::create($request->all());

        return redirect()->route('admin.self-interested-users.index');
    }

    public function edit(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coursehooks = CoursesHook::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $selfInterestedUser->load('user', 'coursehook');

        return view('admin.selfInterestedUsers.edit', compact('users', 'coursehooks', 'selfInterestedUser'));
    }

    public function update(UpdateSelfInterestedUserRequest $request, SelfInterestedUser $selfInterestedUser)
    {
        $selfInterestedUser->update($request->all());

        return redirect()->route('admin.self-interested-users.index');
    }

    public function show(SelfInterestedUser $selfInterestedUser)
    {
        abort_if(Gate::denies('self_interested_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $selfInterestedUser->load('user', 'coursehook');

        return view('admin.selfInterestedUsers.show', compact('selfInterestedUser'));
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
