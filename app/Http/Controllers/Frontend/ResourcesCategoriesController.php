<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyResourcesCategoryRequest;
use App\Http\Requests\StoreResourcesCategoryRequest;
use App\Http\Requests\UpdateResourcesCategoryRequest;
use App\ResourcesCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResourcesCategoriesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('resources_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesCategories = ResourcesCategory::all();

        return view('frontend.resourcesCategories.index', compact('resourcesCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('resources_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.resourcesCategories.create');
    }

    public function store(StoreResourcesCategoryRequest $request)
    {
        $resourcesCategory = ResourcesCategory::create($request->all());

        return redirect()->route('frontend.resources-categories.index');
    }

    public function edit(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.resourcesCategories.edit', compact('resourcesCategory'));
    }

    public function update(UpdateResourcesCategoryRequest $request, ResourcesCategory $resourcesCategory)
    {
        $resourcesCategory->update($request->all());

        return redirect()->route('frontend.resources-categories.index');
    }

    public function show(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesCategory->load('resourcescategoryResourcesSubcategories', 'resourcescategoryResources');

        return view('frontend.resourcesCategories.show', compact('resourcesCategory'));
    }

    public function destroy(ResourcesCategory $resourcesCategory)
    {
        abort_if(Gate::denies('resources_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $resourcesCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyResourcesCategoryRequest $request)
    {
        ResourcesCategory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
