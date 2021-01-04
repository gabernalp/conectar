<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResourcesAuditRequest;
use App\Http\Requests\StoreResourcesAuditRequest;
use App\Http\Requests\UpdateResourcesAuditRequest;
use App\Resource;
use App\ResourcesAudit;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesAuditsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('resources_audit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesAudits = ResourcesAudit::with(['recurso', 'user'])->get();

        return view('frontend.resourcesAudits.index', compact('resourcesAudits'));
    }

    public function create()
    {
        abort_if(Gate::denies('resources_audit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recursos = Resource::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.resourcesAudits.create', compact('recursos', 'users'));
    }

    public function store(StoreResourcesAuditRequest $request)
    {
        $resourcesAudit = ResourcesAudit::create($request->all());

        return redirect()->route('frontend.resources-audits.index');
    }

    public function edit(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $recursos = Resource::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resourcesAudit->load('recurso', 'user');

        return view('frontend.resourcesAudits.edit', compact('recursos', 'users', 'resourcesAudit'));
    }

    public function update(UpdateResourcesAuditRequest $request, ResourcesAudit $resourcesAudit)
    {
        $resourcesAudit->update($request->all());

        return redirect()->route('frontend.resources-audits.index');
    }

    public function show(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesAudit->load('recurso', 'user');

        return view('frontend.resourcesAudits.show', compact('resourcesAudit'));
    }

    public function destroy(ResourcesAudit $resourcesAudit)
    {
        abort_if(Gate::denies('resources_audit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesAudit->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourcesAuditRequest $request)
    {
        ResourcesAudit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
