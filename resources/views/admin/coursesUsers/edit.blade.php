@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.coursesUser.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.courses-users.update", [$coursesUser->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.coursesUser.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $coursesUser->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="course_name">{{ trans('cruds.coursesUser.fields.course_name') }}</label>
                <input class="form-control {{ $errors->has('course_name') ? 'is-invalid' : '' }}" type="text" name="course_name" id="course_name" value="{{ old('course_name', $coursesUser->course_name) }}" required>
                @if($errors->has('course_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('course_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.course_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date_id">{{ trans('cruds.coursesUser.fields.start_date') }}</label>
                <select class="form-control select2 {{ $errors->has('start_date') ? 'is-invalid' : '' }}" name="start_date_id" id="start_date_id" required>
                    @foreach($start_dates as $id => $start_date)
                        <option value="{{ $id }}" {{ (old('start_date_id') ? old('start_date_id') : $coursesUser->start_date->id ?? '') == $id ? 'selected' : '' }}>{{ $start_date }}</option>
                    @endforeach
                </select>
                @if($errors->has('start_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="challenges">{{ trans('cruds.coursesUser.fields.challenges') }}</label>
                <input class="form-control {{ $errors->has('challenges') ? 'is-invalid' : '' }}" type="text" name="challenges" id="challenges" value="{{ old('challenges', $coursesUser->challenges) }}" required>
                @if($errors->has('challenges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('challenges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.challenges_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="badges">{{ trans('cruds.coursesUser.fields.badges') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('badges') ? 'is-invalid' : '' }}" name="badges[]" id="badges" multiple>
                    @foreach($badges as $id => $badges)
                        <option value="{{ $id }}" {{ (in_array($id, old('badges', [])) || $coursesUser->badges->contains($id)) ? 'selected' : '' }}>{{ $badges }}</option>
                    @endforeach
                </select>
                @if($errors->has('badges'))
                    <div class="invalid-feedback">
                        {{ $errors->first('badges') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.coursesUser.fields.badges_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection