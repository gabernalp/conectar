<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyReferenceObjectRequest;
use App\Http\Requests\StoreReferenceObjectRequest;
use App\Http\Requests\UpdateReferenceObjectRequest;
use App\ReferenceObject;
use App\ReferenceType;
use App\Tag;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ReferenceObjectsController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('reference_object_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceObjects = ReferenceObject::with(['referencetype', 'tags', 'media'])->get();

        $reference_types = ReferenceType::get();

        $tags = Tag::get();

        return view('frontend.referenceObjects.index', compact('referenceObjects', 'reference_types', 'tags'));
    }

    public function create()
    {
        abort_if(Gate::denies('reference_object_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referencetypes = ReferenceType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = Tag::all()->pluck('name', 'id');

        return view('frontend.referenceObjects.create', compact('referencetypes', 'tags'));
    }

    public function store(StoreReferenceObjectRequest $request)
    {
        $referenceObject = ReferenceObject::create($request->all());
        $referenceObject->tags()->sync($request->input('tags', []));

        if ($request->input('file', false)) {
            $referenceObject->addMedia(storage_path('tmp/uploads/' . $request->input('file')))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $referenceObject->id]);
        }

        return redirect()->route('frontend.reference-objects.index');
    }

    public function edit(ReferenceObject $referenceObject)
    {
        abort_if(Gate::denies('reference_object_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referencetypes = ReferenceType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $tags = Tag::all()->pluck('name', 'id');

        $referenceObject->load('referencetype', 'tags');

        return view('frontend.referenceObjects.edit', compact('referencetypes', 'tags', 'referenceObject'));
    }

    public function update(UpdateReferenceObjectRequest $request, ReferenceObject $referenceObject)
    {
        $referenceObject->update($request->all());
        $referenceObject->tags()->sync($request->input('tags', []));

        if ($request->input('file', false)) {
            if (!$referenceObject->file || $request->input('file') !== $referenceObject->file->file_name) {
                if ($referenceObject->file) {
                    $referenceObject->file->delete();
                }

                $referenceObject->addMedia(storage_path('tmp/uploads/' . $request->input('file')))->toMediaCollection('file');
            }
        } elseif ($referenceObject->file) {
            $referenceObject->file->delete();
        }

        return redirect()->route('frontend.reference-objects.index');
    }

    public function show(ReferenceObject $referenceObject)
    {
        abort_if(Gate::denies('reference_object_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceObject->load('referencetype', 'tags', 'referencesCourses');

        return view('frontend.referenceObjects.show', compact('referenceObject'));
    }

    public function destroy(ReferenceObject $referenceObject)
    {
        abort_if(Gate::denies('reference_object_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $referenceObject->delete();

        return back();
    }

    public function massDestroy(MassDestroyReferenceObjectRequest $request)
    {
        ReferenceObject::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('reference_object_create') && Gate::denies('reference_object_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ReferenceObject();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
