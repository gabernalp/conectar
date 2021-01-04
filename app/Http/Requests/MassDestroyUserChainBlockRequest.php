<?php

namespace App\Http\Requests;

use App\UserChainBlock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserChainBlockRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_chain_block_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:user_chain_blocks,id',
        ];
    }
}
