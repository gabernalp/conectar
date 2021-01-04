@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.challengesUser.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.challenges-users.update", [$challengesUser->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="challenge_id">{{ trans('cruds.challengesUser.fields.challenge') }}</label>
                            <select class="form-control select2" name="challenge_id" id="challenge_id">
                                @foreach($challenges as $id => $challenge)
                                    <option value="{{ $id }}" {{ (old('challenge_id') ? old('challenge_id') : $challengesUser->challenge->id ?? '') == $id ? 'selected' : '' }}>{{ $challenge }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('challenge'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('challenge') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.challengesUser.fields.challenge_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="user_id">{{ trans('cruds.challengesUser.fields.user') }}</label>
                            <select class="form-control select2" name="user_id" id="user_id">
                                @foreach($users as $id => $user)
                                    <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $challengesUser->user->id ?? '') == $id ? 'selected' : '' }}>{{ $user }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('user'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('user') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.challengesUser.fields.user_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="reference_text">{{ trans('cruds.challengesUser.fields.reference_text') }}</label>
                            <textarea class="form-control" name="reference_text" id="reference_text">{{ old('reference_text', $challengesUser->reference_text) }}</textarea>
                            @if($errors->has('reference_text'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_text') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.challengesUser.fields.reference_text_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="reference_media">{{ trans('cruds.challengesUser.fields.reference_media') }}</label>
                            <input class="form-control" type="text" name="reference_media" id="reference_media" value="{{ old('reference_media', $challengesUser->reference_media) }}">
                            @if($errors->has('reference_media'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference_media') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.challengesUser.fields.reference_media_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.challengesUser.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\ChallengesUser::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $challengesUser->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.challengesUser.fields.status_helper') }}</span>
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