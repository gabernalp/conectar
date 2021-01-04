@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('background_process_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.background-processes.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.backgroundProcess.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'BackgroundProcess', 'route' => 'admin.background-processes.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.backgroundProcess.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-BackgroundProcess">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.description') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.tags') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.file') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.images') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.backgroundProcess.fields.comments') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($backgroundProcesses as $key => $backgroundProcess)
                                    <tr data-entry-id="{{ $backgroundProcess->id }}">
                                        <td>
                                            {{ $backgroundProcess->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $backgroundProcess->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $backgroundProcess->description ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($backgroundProcess->tags as $key => $item)
                                                <span>{{ $item->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($backgroundProcess->file as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank">
                                                    {{ trans('global.view_file') }}
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($backgroundProcess->images as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $backgroundProcess->comments ?? '' }}
                                        </td>
                                        <td>
                                            @can('background_process_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.background-processes.show', $backgroundProcess->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('background_process_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.background-processes.edit', $backgroundProcess->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('background_process_delete')
                                                <form action="{{ route('frontend.background-processes.destroy', $backgroundProcess->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('background_process_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.background-processes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 10,
  });
  let table = $('.datatable-BackgroundProcess:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection