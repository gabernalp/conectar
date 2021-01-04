<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserChainBlockRequest;
use App\Http\Requests\StoreUserChainBlockRequest;
use App\Http\Requests\UpdateUserChainBlockRequest;
use App\UserChainBlock;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserChainBlocksController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_chain_block_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userChainBlocks = UserChainBlock::with(['user', 'referencetype'])->get();

        return view('frontend.userChainBlocks.index', compact('userChainBlocks'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_chain_block_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.userChainBlocks.create');
    }

    public function store(StoreUserChainBlockRequest $request)
    {
        $userChainBlock = UserChainBlock::create($request->all());

        return redirect()->route('frontend.user-chain-blocks.index');
    }

    public function edit(UserChainBlock $userChainBlock)
    {
        abort_if(Gate::denies('user_chain_block_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userChainBlock->load('user', 'referencetype');

        return view('frontend.userChainBlocks.edit', compact('userChainBlock'));
    }

    public function update(UpdateUserChainBlockRequest $request, UserChainBlock $userChainBlock)
    {
        $userChainBlock->update($request->all());

        return redirect()->route('frontend.user-chain-blocks.index');
    }

    public function show(UserChainBlock $userChainBlock)
    {
        abort_if(Gate::denies('user_chain_block_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userChainBlock->load('user', 'referencetype');

        return view('frontend.userChainBlocks.show', compact('userChainBlock'));
    }

    public function destroy(UserChainBlock $userChainBlock)
    {
        abort_if(Gate::denies('user_chain_block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userChainBlock->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserChainBlockRequest $request)
    {
        UserChainBlock::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
