<?php

namespace App\Http\Controllers\Frontend;

use App\Challenge;
use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyChallengeRequest;
use App\Http\Requests\StoreChallengeRequest;
use App\Http\Requests\UpdateChallengeRequest;
use App\PointsRule;
use App\ReferenceType;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ChallengesController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('challenge_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenges = Challenge::with(['courses', 'referencetype', 'points', 'media'])->get();

        return view('frontend.challenges.index', compact('challenges'));
    }

    public function create()
    {
        abort_if(Gate::denies('challenge_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::all()->pluck('name', 'id');

        $referencetypes = ReferenceType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $points = PointsRule::all()->pluck('points_item', 'id');

        return view('frontend.challenges.create', compact('courses', 'referencetypes', 'points'));
    }

    public function store(StoreChallengeRequest $request)
    {
        $challenge = Challenge::create($request->all());
        $challenge->courses()->sync($request->input('courses', []));
        $challenge->points()->sync($request->input('points', []));

        if ($request->input('capsule_file', false)) {
            $challenge->addMedia(storage_path('tmp/uploads/' . $request->input('capsule_file')))->toMediaCollection('capsule_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $challenge->id]);
        }

        return redirect()->route('frontend.challenges.index');
    }

    public function edit(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::all()->pluck('name', 'id');

        $referencetypes = ReferenceType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $points = PointsRule::all()->pluck('points_item', 'id');

        $challenge->load('courses', 'referencetype', 'points');

        return view('frontend.challenges.edit', compact('courses', 'referencetypes', 'points', 'challenge'));
    }

    public function update(UpdateChallengeRequest $request, Challenge $challenge)
    {
        $challenge->update($request->all());
        $challenge->courses()->sync($request->input('courses', []));
        $challenge->points()->sync($request->input('points', []));

        if ($request->input('capsule_file', false)) {
            if (!$challenge->capsule_file || $request->input('capsule_file') !== $challenge->capsule_file->file_name) {
                if ($challenge->capsule_file) {
                    $challenge->capsule_file->delete();
                }

                $challenge->addMedia(storage_path('tmp/uploads/' . $request->input('capsule_file')))->toMediaCollection('capsule_file');
            }
        } elseif ($challenge->capsule_file) {
            $challenge->capsule_file->delete();
        }

        return redirect()->route('frontend.challenges.index');
    }

    public function show(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge->load('courses', 'referencetype', 'points', 'challengeChallengesUsers');

        return view('frontend.challenges.show', compact('challenge'));
    }

    public function destroy(Challenge $challenge)
    {
        abort_if(Gate::denies('challenge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge->delete();

        return back();
    }

    public function massDestroy(MassDestroyChallengeRequest $request)
    {
        Challenge::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('challenge_create') && Gate::denies('challenge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Challenge();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
