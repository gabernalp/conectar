@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.coursesHook.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses-hooks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.id') }}
                        </th>
                        <td>
                            {{ $coursesHook->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.name') }}
                        </th>
                        <td>
                            {{ $coursesHook->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.description') }}
                        </th>
                        <td>
                            {{ $coursesHook->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.requirements') }}
                        </th>
                        <td>
                            {{ $coursesHook->requirements }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.link') }}
                        </th>
                        <td>
                            {{ $coursesHook->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.priorized') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coursesHook->priorized ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.rol') }}
                        </th>
                        <td>
                            @foreach($coursesHook->rols as $key => $rol)
                                <span class="label label-info">{{ $rol->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.educational_level') }}
                        </th>
                        <td>
                            {{ App\CoursesHook::EDUCATIONAL_LEVEL_SELECT[$coursesHook->educational_level] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.coursesHook.fields.growinghook') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $coursesHook->growinghook ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.courses-hooks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#courseshooks_courses" role="tab" data-toggle="tab">
                {{ trans('cruds.course.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="courseshooks_courses">
            @includeIf('admin.coursesHooks.relationships.courseshooksCourses', ['courses' => $coursesHook->courseshooksCourses])
        </div>
    </div>
</div>

@endsection