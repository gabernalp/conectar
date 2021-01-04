<?php

namespace App\Http\Controllers\Frontend;

use App\FeedbacksUser;
use App\FeedbackType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFeedbacksUserRequest;
use App\Http\Requests\StoreFeedbacksUserRequest;
use App\Http\Requests\UpdateFeedbacksUserRequest;
use App\ReferenceType;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FeedbacksUsersController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('feedbacks_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbacksUsers = FeedbacksUser::with(['programmed_course', 'user', 'feedbacktype', 'referencetype', 'created_by', 'media'])->get();

        return view('frontend.feedbacksUsers.index', compact('feedbacksUsers'));
    }

    public function create()
    {
        abort_if(Gate::denies('feedbacks_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $feedbacktypes = FeedbackType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referencetypes = ReferenceType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.feedbacksUsers.create', compact('users', 'feedbacktypes', 'referencetypes'));
    }

    public function store(StoreFeedbacksUserRequest $request)
    {
        $feedbacksUser = FeedbacksUser::create($request->all());

        if ($request->input('file', false)) {
            $feedbacksUser->addMedia(storage_path('tmp/uploads/' . $request->input('file')))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $feedbacksUser->id]);
        }

        return redirect()->route('frontend.feedbacks-users.index');
    }

    public function edit(FeedbacksUser $feedbacksUser)
    {
        abort_if(Gate::denies('feedbacks_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $feedbacktypes = FeedbackType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $referencetypes = ReferenceType::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $feedbacksUser->load('programmed_course', 'user', 'feedbacktype', 'referencetype', 'created_by');

        return view('frontend.feedbacksUsers.edit', compact('users', 'feedbacktypes', 'referencetypes', 'feedbacksUser'));
    }

    public function update(UpdateFeedbacksUserRequest $request, FeedbacksUser $feedbacksUser)
    {
        $feedbacksUser->update($request->all());

        if ($request->input('file', false)) {
            if (!$feedbacksUser->file || $request->input('file') !== $feedbacksUser->file->file_name) {
                if ($feedbacksUser->file) {
                    $feedbacksUser->file->delete();
                }

                $feedbacksUser->addMedia(storage_path('tmp/uploads/' . $request->input('file')))->toMediaCollection('file');
            }
        } elseif ($feedbacksUser->file) {
            $feedbacksUser->file->delete();
        }

        return redirect()->route('frontend.feedbacks-users.index');
    }

    public function show(FeedbacksUser $feedbacksUser)
    {
        abort_if(Gate::denies('feedbacks_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbacksUser->load('programmed_course', 'user', 'feedbacktype', 'referencetype', 'created_by');

        return view('frontend.feedbacksUsers.show', compact('feedbacksUser'));
    }

    public function destroy(FeedbacksUser $feedbacksUser)
    {
        abort_if(Gate::denies('feedbacks_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbacksUser->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeedbacksUserRequest $request)
    {
        FeedbacksUser::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('feedbacks_user_create') && Gate::denies('feedbacks_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new FeedbacksUser();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
