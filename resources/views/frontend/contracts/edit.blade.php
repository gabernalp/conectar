@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.contract.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.contracts.update", [$contract->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.contract.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $contract->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="start_date">{{ trans('cruds.contract.fields.start_date') }}</label>
                            <input class="form-control date" type="text" name="start_date" id="start_date" value="{{ old('start_date', $contract->start_date) }}">
                            @if($errors->has('start_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.start_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="end_date">{{ trans('cruds.contract.fields.end_date') }}</label>
                            <input class="form-control" type="text" name="end_date" id="end_date" value="{{ old('end_date', $contract->end_date) }}">
                            @if($errors->has('end_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.end_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="operator_id">{{ trans('cruds.contract.fields.operator') }}</label>
                            <select class="form-control select2" name="operator_id" id="operator_id">
                                @foreach($operators as $id => $operator)
                                    <option value="{{ $id }}" {{ (old('operator_id') ? old('operator_id') : $contract->operator->id ?? '') == $id ? 'selected' : '' }}>{{ $operator }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('operator'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('operator') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.operator_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="entities">{{ trans('cruds.contract.fields.entity') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="entities[]" id="entities" multiple>
                                @foreach($entities as $id => $entity)
                                    <option value="{{ $id }}" {{ (in_array($id, old('entities', [])) || $contract->entities->contains($id)) ? 'selected' : '' }}>{{ $entity }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('entities'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('entities') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.contract.fields.entity_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection