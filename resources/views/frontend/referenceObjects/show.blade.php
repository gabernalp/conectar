@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.referenceObject.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.reference-objects.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $referenceObject->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.referencetype') }}
                                    </th>
                                    <td>
                                        {{ $referenceObject->referencetype->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.title') }}
                                    </th>
                                    <td>
                                        {{ $referenceObject->title }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.link') }}
                                    </th>
                                    <td>
                                        {{ $referenceObject->link }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.file') }}
                                    </th>
                                    <td>
                                        @if($referenceObject->file)
                                            <a href="{{ $referenceObject->file->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.image') }}
                                    </th>
                                    <td>
                                        {{ $referenceObject->image }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.tags') }}
                                    </th>
                                    <td>
                                        @foreach($referenceObject->tags as $key => $tags)
                                            <span class="label label-info">{{ $tags->name }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.referenceObject.fields.comments') }}
                                    </th>
                                    <td>
                                        {{ $referenceObject->comments }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.reference-objects.index') }}">
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