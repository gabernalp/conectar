<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySubcategoriesSetRequest;
use App\Http\Requests\StoreSubcategoriesSetRequest;
use App\Http\Requests\UpdateSubcategoriesSetRequest;
use App\ResourcesCategory;
use App\ResourcesSubcategory;
use App\SubcategoriesSet;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubcategoriesSetsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('subcategories_set_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subcategoriesSets = SubcategoriesSet::with(['resourcescategory', 'resourcessubcategory'])->get();

        return view('frontend.subcategoriesSets.index', compact('subcategoriesSets'));
    }

    public function create()
    {
        abort_if(Gate::denies('subcategories_set_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resourcessubcategories = ResourcesSubcategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.subcategoriesSets.create', compact('resourcescategories', 'resourcessubcategories'));
    }

    public function store(StoreSubcategoriesSetRequest $request)
    {
        $subcategoriesSet = SubcategoriesSet::create($request->all());

        return redirect()->route('frontend.subcategories-sets.index');
    }

    public function edit(SubcategoriesSet $subcategoriesSet)
    {
        abort_if(Gate::denies('subcategories_set_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resourcessubcategories = ResourcesSubcategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subcategoriesSet->load('resourcescategory', 'resourcessubcategory');

        return view('frontend.subcategoriesSets.edit', compact('resourcescategories', 'resourcessubcategories', 'subcategoriesSet'));
    }

    public function update(UpdateSubcategoriesSetRequest $request, SubcategoriesSet $subcategoriesSet)
    {
        $subcategoriesSet->update($request->all());

        return redirect()->route('frontend.subcategories-sets.index');
    }

    public function show(SubcategoriesSet $subcategoriesSet)
    {
        abort_if(Gate::denies('subcategories_set_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subcategoriesSet->load('resourcescategory', 'resourcessubcategory', 'subcategoriessetResources');

        return view('frontend.subcategoriesSets.show', compact('subcategoriesSet'));
    }

    public function destroy(SubcategoriesSet $subcategoriesSet)
    {
        abort_if(Gate::denies('subcategories_set_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subcategoriesSet->delete();

        return back();
    }

    public function massDestroy(MassDestroySubcategoriesSetRequest $request)
    {
        SubcategoriesSet::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
