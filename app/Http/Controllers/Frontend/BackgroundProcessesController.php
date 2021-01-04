<?php

namespace App\Http\Controllers\Frontend;

use App\BackgroundProcess;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBackgroundProcessRequest;
use App\Http\Requests\StoreBackgroundProcessRequest;
use App\Http\Requests\UpdateBackgroundProcessRequest;
use App\Tag;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BackgroundProcessesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('background_process_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $backgroundProcesses = BackgroundProcess::with(['tags', 'media'])->get();

        return view('frontend.backgroundProcesses.index', compact('backgroundProcesses'));
    }

    public function create()
    {
        abort_if(Gate::denies('background_process_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all()->pluck('name', 'id');

        return view('frontend.backgroundProcesses.create', compact('tags'));
    }

    public function store(StoreBackgroundProcessRequest $request)
    {
        $backgroundProcess = BackgroundProcess::create($request->all());
        $backgroundProcess->tags()->sync($request->input('tags', []));

        foreach ($request->input('file', []) as $file) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file');
        }

        foreach ($request->input('images', []) as $file) {
            $backgroundProcess->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $backgroundProcess->id]);
        }

        return redirect()->route('frontend.background-processes.index');
    }

    public function edit(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tags = Tag::all()->pluck('name', 'id');

        $backgroundProcess->load('tags');

        return view('frontend.backgroundProcesses.edit', compact('tags', 'backgroundProcess'));
    }

    public function update(UpdateBackgroundProcessRequest $request, BackgroundProcess $backgroundProcess)
    {
        $backgroundProcess->update($request->all());
        $backgroundProcess->tags()->sync($request->input('tags', []));

        if (count($backgroundProcess->file) > 0) {
            foreach ($backgroundProcess->file as $media) {
                if (!in_array($media->file_name, $request->input('file', []))) {
                    $media->delete();
                }
            }
        }

        $media = $backgroundProcess->file->pluck('file_name')->toArray();

        foreach ($request->input('file', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('file');
            }
        }

        if (count($backgroundProcess->images) > 0) {
            foreach ($backgroundProcess->images as $media) {
                if (!in_array($media->file_name, $request->input('images', []))) {
                    $media->delete();
                }
            }
        }

        $media = $backgroundProcess->images->pluck('file_name')->toArray();

        foreach ($request->input('images', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $backgroundProcess->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('images');
            }
        }

        return redirect()->route('frontend.background-processes.index');
    }

    public function show(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $backgroundProcess->load('tags', 'associatedProcessesCourses');

        return view('frontend.backgroundProcesses.show', compact('backgroundProcess'));
    }

    public function destroy(BackgroundProcess $backgroundProcess)
    {
        abort_if(Gate::denies('background_process_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $backgroundProcess->delete();

        return back();
    }

    public function massDestroy(MassDestroyBackgroundProcessRequest $request)
    {
        BackgroundProcess::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('background_process_create') && Gate::denies('background_process_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BackgroundProcess();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
