@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.coursesUser.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.courses-users.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="user_id">{{ trans('cruds.coursesUser.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id">
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
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
                            <input class="form-control" type="text" name="course_name" id="course_name" value="{{ old('course_name', '') }}" required>
                            @if($errors->has('course_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('course_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesUser.fields.course_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="start_date_id">{{ trans('cruds.coursesUser.fields.start_date') }}</label>
                            <select class="form-control select2" name="start_date_id" id="start_date_id" required>
                                @foreach($start_dates as $id => $start_date)
                                    <option value="{{ $id }}" {{ old('start_date_id') == $id ? 'selected' : '' }}>{{ $start_date }}</option>
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
                            <input class="form-control" type="text" name="challenges" id="challenges" value="{{ old('challenges', '') }}" required>
                            @if($errors->has('challenges'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('challenges') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.coursesUser.fields.challenges_helper') }}</span>
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