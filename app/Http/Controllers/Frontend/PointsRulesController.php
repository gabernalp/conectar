<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyPointsRuleRequest;
use App\Http\Requests\StorePointsRuleRequest;
use App\Http\Requests\UpdatePointsRuleRequest;
use App\PointsRule;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PointsRulesController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('points_rule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pointsRules = PointsRule::all();

        return view('frontend.pointsRules.index', compact('pointsRules'));
    }

    public function create()
    {
        abort_if(Gate::denies('points_rule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.pointsRules.create');
    }

    public function store(StorePointsRuleRequest $request)
    {
        $pointsRule = PointsRule::create($request->all());

        return redirect()->route('frontend.points-rules.index');
    }

    public function edit(PointsRule $pointsRule)
    {
        abort_if(Gate::denies('points_rule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.pointsRules.edit', compact('pointsRule'));
    }

    public function update(UpdatePointsRuleRequest $request, PointsRule $pointsRule)
    {
        $pointsRule->update($request->all());

        return redirect()->route('frontend.points-rules.index');
    }

    public function show(PointsRule $pointsRule)
    {
        abort_if(Gate::denies('points_rule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.pointsRules.show', compact('pointsRule'));
    }

    public function destroy(PointsRule $pointsRule)
    {
        abort_if(Gate::denies('points_rule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pointsRule->delete();

        return back();
    }

    public function massDestroy(MassDestroyPointsRuleRequest $request)
    {
        PointsRule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
