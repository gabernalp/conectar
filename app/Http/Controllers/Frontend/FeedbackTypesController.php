<?php

namespace App\Http\Controllers\Frontend;

use App\FeedbackType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyFeedbackTypeRequest;
use App\Http\Requests\StoreFeedbackTypeRequest;
use App\Http\Requests\UpdateFeedbackTypeRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedbackTypesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('feedback_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackTypes = FeedbackType::all();

        return view('frontend.feedbackTypes.index', compact('feedbackTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('feedback_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.feedbackTypes.create');
    }

    public function store(StoreFeedbackTypeRequest $request)
    {
        $feedbackType = FeedbackType::create($request->all());

        return redirect()->route('frontend.feedback-types.index');
    }

    public function edit(FeedbackType $feedbackType)
    {
        abort_if(Gate::denies('feedback_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.feedbackTypes.edit', compact('feedbackType'));
    }

    public function update(UpdateFeedbackTypeRequest $request, FeedbackType $feedbackType)
    {
        $feedbackType->update($request->all());

        return redirect()->route('frontend.feedback-types.index');
    }

    public function show(FeedbackType $feedbackType)
    {
        abort_if(Gate::denies('feedback_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.feedbackTypes.show', compact('feedbackType'));
    }

    public function destroy(FeedbackType $feedbackType)
    {
        abort_if(Gate::denies('feedback_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbackType->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeedbackTypeRequest $request)
    {
        FeedbackType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
