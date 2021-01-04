@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.coursesHook.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.courses-hooks.update", [$coursesHook->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.coursesHook.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $coursesHook->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.coursesHook.fields.description') }}</label>
                            <textarea class="form-control" name="description" id="description">{{ old('description', $coursesHook->description) }}</textarea>
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="requirements">{{ trans('cruds.coursesHook.fields.requirements') }}</label>
                            <textarea class="form-control" name="requirements" id="requirements">{{ old('requirements', $coursesHook->requirements) }}</textarea>
                            @if($errors->has('requirements'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('requirements') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.requirements_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="link">{{ trans('cruds.coursesHook.fields.link') }}</label>
                            <input class="form-control" type="text" name="link" id="link" value="{{ old('link', $coursesHook->link) }}">
                            @if($errors->has('link'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('link') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.link_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="priorized" value="0">
                                <input type="checkbox" name="priorized" id="priorized" value="1" {{ $coursesHook->priorized || old('priorized', 0) === 1 ? 'checked' : '' }}>
                                <label for="priorized">{{ trans('cruds.coursesHook.fields.priorized') }}</label>
                            </div>
                            @if($errors->has('priorized'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('priorized') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.priorized_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="rols">{{ trans('cruds.coursesHook.fields.rol') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="rols[]" id="rols" multiple>
                                @foreach($rols as $id => $rol)
                                    <option value="{{ $id }}" {{ (in_array($id, old('rols', [])) || $coursesHook->rols->contains($id)) ? 'selected' : '' }}>{{ $rol }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('rols'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('rols') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.rol_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.coursesHook.fields.educational_level') }}</label>
                            <select class="form-control" name="educational_level" id="educational_level">
                                <option value disabled {{ old('educational_level', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\CoursesHook::EDUCATIONAL_LEVEL_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('educational_level', $coursesHook->educational_level) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('educational_level'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('educational_level') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.educational_level_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="growinghook" value="0">
                                <input type="checkbox" name="growinghook" id="growinghook" value="1" {{ $coursesHook->growinghook || old('growinghook', 0) === 1 ? 'checked' : '' }}>
                                <label for="growinghook">{{ trans('cruds.coursesHook.fields.growinghook') }}</label>
                            </div>
                            @if($errors->has('growinghook'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('growinghook') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesHook.fields.growinghook_helper') }}</span>
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