<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResourcesSubcategoryRequest;
use App\Http\Requests\StoreResourcesSubcategoryRequest;
use App\Http\Requests\UpdateResourcesSubcategoryRequest;
use App\ResourcesCategory;
use App\ResourcesSubcategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesSubcategoriesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('resources_subcategory_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesSubcategories = ResourcesSubcategory::with(['resourcescategory'])->get();

        return view('frontend.resourcesSubcategories.index', compact('resourcesSubcategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('resources_subcategory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.resourcesSubcategories.create', compact('resourcescategories'));
    }

    public function store(StoreResourcesSubcategoryRequest $request)
    {
        $resourcesSubcategory = ResourcesSubcategory::create($request->all());

        return redirect()->route('frontend.resources-subcategories.index');
    }

    public function edit(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcescategories = ResourcesCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $resourcesSubcategory->load('resourcescategory');

        return view('frontend.resourcesSubcategories.edit', compact('resourcescategories', 'resourcesSubcategory'));
    }

    public function update(UpdateResourcesSubcategoryRequest $request, ResourcesSubcategory $resourcesSubcategory)
    {
        $resourcesSubcategory->update($request->all());

        return redirect()->route('frontend.resources-subcategories.index');
    }

    public function show(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesSubcategory->load('resourcescategory', 'resourcessubcategorySubcategoriesSets', 'resourcessubcategoryResources');

        return view('frontend.resourcesSubcategories.show', compact('resourcesSubcategory'));
    }

    public function destroy(ResourcesSubcategory $resourcesSubcategory)
    {
        abort_if(Gate::denies('resources_subcategory_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesSubcategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourcesSubcategoryRequest $request)
    {
        ResourcesSubcategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
