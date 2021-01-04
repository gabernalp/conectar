@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.selfInterestedUser.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.self-interested-users.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="user_id">{{ trans('cruds.selfInterestedUser.fields.user') }}</label>
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
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="coursehook_id">{{ trans('cruds.selfInterestedUser.fields.coursehook') }}</label>
                            <select class="form-control select2" name="coursehook_id" id="coursehook_id">
                                @foreach($coursehooks as $id => $coursehook)
                                    <option value="{{ $id }}" {{ old('coursehook_id') == $id ? 'selected' : '' }}>{{ $coursehook }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('coursehook'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('coursehook') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.coursehook_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="contact" value="0">
                                <input type="checkbox" name="contact" id="contact" value="1" {{ old('contact', 0) == 1 ? 'checked' : '' }}>
                                <label for="contact">{{ trans('cruds.selfInterestedUser.fields.contact') }}</label>
                            </div>
                            @if($errors->has('contact'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('contact') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.selfInterestedUser.fields.contact_helper') }}</span>
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