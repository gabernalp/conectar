<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyReferenceTypeRequest;
use App\Http\Requests\StoreReferenceTypeRequest;
use App\Http\Requests\UpdateReferenceTypeRequest;
use App\ReferenceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReferenceTypesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('reference_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceTypes = ReferenceType::all();

        return view('frontend.referenceTypes.index', compact('referenceTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('reference_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.referenceTypes.create');
    }

    public function store(StoreReferenceTypeRequest $request)
    {
        $referenceType = ReferenceType::create($request->all());

        return redirect()->route('frontend.reference-types.index');
    }

    public function edit(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.referenceTypes.edit', compact('referenceType'));
    }

    public function update(UpdateReferenceTypeRequest $request, ReferenceType $referenceType)
    {
        $referenceType->update($request->all());

        return redirect()->route('frontend.reference-types.index');
    }

    public function show(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceType->load('referencetypeReferenceObjects');

        return view('frontend.referenceTypes.show', compact('referenceType'));
    }

    public function destroy(ReferenceType $referenceType)
    {
        abort_if(Gate::denies('reference_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceType->delete();

        return back();
    }

    public function massDestroy(MassDestroyReferenceTypeRequest $request)
    {
        ReferenceType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
