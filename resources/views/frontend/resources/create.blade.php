@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.resource.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.resources.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="resourcescategory_id">{{ trans('cruds.resource.fields.resourcescategory') }}</label>
                            <select class="form-control select2" name="resourcescategory_id" id="resourcescategory_id" required>
                                @foreach($resourcescategories as $id => $resourcescategory)
                                    <option value="{{ $id }}" {{ old('resourcescategory_id') == $id ? 'selected' : '' }}>{{ $resourcescategory }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('resourcescategory'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('resourcescategory') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.resource.fields.resourcescategory_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="resourcessubcategory_id">{{ trans('cruds.resource.fields.resourcessubcategory') }}</label>
                            <select class="form-control select2" name="resourcessubcategory_id" id="resourcessubcategory_id">
                                @foreach($resourcessubcategories as $id => $resourcessubcategory)
                                    <option value="{{ $id }}" {{ old('resourcessubcategory_id') == $id ? 'selected' : '' }}>{{ $resourcessubcategory }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('resourcessubcategory'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('resourcessubcategory') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.resource.fields.resourcessubcategory_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="subcategoriesset_id">{{ trans('cruds.resource.fields.subcategoriesset') }}</label>
                            <select class="form-control select2" name="subcategoriesset_id" id="subcategoriesset_id">
                                @foreach($subcategoriessets as $id => $subcategoriesset)
                                    <option value="{{ $id }}" {{ old('subcategoriesset_id') == $id ? 'selected' : '' }}>{{ $subcategoriesset }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('subcategoriesset'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('subcategoriesset') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.resource.fields.subcategoriesset_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.resource.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.resource.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="file">{{ trans('cruds.resource.fields.file') }}</label>
                            <div class="needsclick dropzone" id="file-dropzone">
                            </div>
                            @if($errors->has('file'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('file') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.resource.fields.file_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="comments">{{ trans('cruds.resource.fields.comments') }}</label>
                            <textarea class="form-control" name="comments" id="comments">{{ old('comments') }}</textarea>
                            @if($errors->has('comments'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('comments') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.resource.fields.comments_helper') }}</span>
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

@section('scripts')
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('frontend.resources.storeMedia') }}',
    maxFilesize: 10, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($resource) && $resource->file)
      var file = {!! json_encode($resource->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection