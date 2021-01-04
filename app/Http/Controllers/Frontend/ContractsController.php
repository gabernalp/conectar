<?php

namespace App\Http\Controllers\Frontend;

use App\Contract;
use App\Entity;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContractRequest;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Operator;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContractsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contracts = Contract::with(['operator', 'entities'])->get();

        return view('frontend.contracts.index', compact('contracts'));
    }

    public function create()
    {
        abort_if(Gate::denies('contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operators = Operator::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $entities = Entity::all()->pluck('name', 'id');

        return view('frontend.contracts.create', compact('operators', 'entities'));
    }

    public function store(StoreContractRequest $request)
    {
        $contract = Contract::create($request->all());
        $contract->entities()->sync($request->input('entities', []));

        return redirect()->route('frontend.contracts.index');
    }

    public function edit(Contract $contract)
    {
        abort_if(Gate::denies('contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operators = Operator::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $entities = Entity::all()->pluck('name', 'id');

        $contract->load('operator', 'entities');

        return view('frontend.contracts.edit', compact('operators', 'entities', 'contract'));
    }

    public function update(UpdateContractRequest $request, Contract $contract)
    {
        $contract->update($request->all());
        $contract->entities()->sync($request->input('entities', []));

        return redirect()->route('frontend.contracts.index');
    }

    public function show(Contract $contract)
    {
        abort_if(Gate::denies('contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract->load('operator', 'entities');

        return view('frontend.contracts.show', compact('contract'));
    }

    public function destroy(Contract $contract)
    {
        abort_if(Gate::denies('contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contract->delete();

        return back();
    }

    public function massDestroy(MassDestroyContractRequest $request)
    {
        Contract::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
