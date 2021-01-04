<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOperatorRequest;
use App\Http\Requests\StoreOperatorRequest;
use App\Http\Requests\UpdateOperatorRequest;
use App\Operator;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OperatorsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('operator_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operators = Operator::all();

        return view('frontend.operators.index', compact('operators'));
    }

    public function create()
    {
        abort_if(Gate::denies('operator_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.operators.create');
    }

    public function store(StoreOperatorRequest $request)
    {
        $operator = Operator::create($request->all());

        return redirect()->route('frontend.operators.index');
    }

    public function edit(Operator $operator)
    {
        abort_if(Gate::denies('operator_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.operators.edit', compact('operator'));
    }

    public function update(UpdateOperatorRequest $request, Operator $operator)
    {
        $operator->update($request->all());

        return redirect()->route('frontend.operators.index');
    }

    public function show(Operator $operator)
    {
        abort_if(Gate::denies('operator_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operator->load('operatorContracts', 'operatorUsers', 'operatorsCourses');

        return view('frontend.operators.show', compact('operator'));
    }

    public function destroy(Operator $operator)
    {
        abort_if(Gate::denies('operator_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operator->delete();

        return back();
    }

    public function massDestroy(MassDestroyOperatorRequest $request)
    {
        Operator::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
