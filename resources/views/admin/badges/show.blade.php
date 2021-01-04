@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.badge.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.badges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.badge.fields.id') }}
                        </th>
                        <td>
                            {{ $badge->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.badge.fields.name') }}
                        </th>
                        <td>
                            {{ $badge->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.badge.fields.image') }}
                        </th>
                        <td>
                            @if($badge->image)
                                <a href="{{ $badge->image->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $badge->image->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.badge.fields.points') }}
                        </th>
                        <td>
                            {{ $badge->points }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.badges.index') }}">
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
            <a class="nav-link" href="#badges_courses_users" role="tab" data-toggle="tab">
                {{ trans('cruds.coursesUser.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="badges_courses_users">
            @includeIf('admin.badges.relationships.badgesCoursesUsers', ['coursesUsers' => $badge->badgesCoursesUsers])
        </div>
    </div>
</div>

@endsection