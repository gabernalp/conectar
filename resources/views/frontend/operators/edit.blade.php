@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.operator.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.operators.update", [$operator->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.operator.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $operator->name) }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.operator.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="nit">{{ trans('cruds.operator.fields.nit') }}</label>
                            <input class="form-control" type="text" name="nit" id="nit" value="{{ old('nit', $operator->nit) }}">
                            @if($errors->has('nit'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nit') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.operator.fields.nit_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="observaciones">{{ trans('cruds.operator.fields.observaciones') }}</label>
                            <textarea class="form-control" name="observaciones" id="observaciones">{{ old('observaciones', $operator->observaciones) }}</textarea>
                            @if($errors->has('observaciones'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('observaciones') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.operator.fields.observaciones_helper') }}</span>
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