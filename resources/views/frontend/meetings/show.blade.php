@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.meeting.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.meetings.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $meeting->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.user') }}
                                    </th>
                                    <td>
                                        {{ $meeting->user->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $meeting->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.description') }}
                                    </th>
                                    <td>
                                        {{ $meeting->description }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.departments') }}
                                    </th>
                                    <td>
                                        @foreach($meeting->departments as $key => $departments)
                                            <span class="label label-info">{{ $departments->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.tags') }}
                                    </th>
                                    <td>
                                        @foreach($meeting->tags as $key => $tags)
                                            <span class="label label-info">{{ $tags->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.date') }}
                                    </th>
                                    <td>
                                        {{ $meeting->date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.time') }}
                                    </th>
                                    <td>
                                        {{ $meeting->time }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.link') }}
                                    </th>
                                    <td>
                                        {{ $meeting->link }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.confirmed') }}
                                    </th>
                                    <td>
                                        <input type="checkbox" disabled="disabled" {{ $meeting->confirmed ? 'checked' : '' }}>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.file') }}
                                    </th>
                                    <td>
                                        @if($meeting->file)
                                            <a href="{{ $meeting->file->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meeting.fields.observaciones') }}
                                    </th>
                                    <td>
                                        {{ $meeting->observaciones }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.meetings.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection