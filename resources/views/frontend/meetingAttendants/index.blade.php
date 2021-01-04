@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('meeting_attendant_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.meeting-attendants.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.meetingAttendant.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'MeetingAttendant', 'route' => 'admin.meeting-attendants.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.meetingAttendant.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-MeetingAttendant">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.meetingAttendant.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.meetingAttendant.fields.meeting') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.meeting.fields.date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.meetingAttendant.fields.user') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.last_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.document') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meetingAttendants as $key => $meetingAttendant)
                                    <tr data-entry-id="{{ $meetingAttendant->id }}">
                                        <td>
                                            {{ $meetingAttendant->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $meetingAttendant->meeting->title ?? '' }}
                                        </td>
                                        <td>
                                            {{ $meetingAttendant->meeting->date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $meetingAttendant->user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $meetingAttendant->user->last_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $meetingAttendant->user->document ?? '' }}
                                        </td>
                                        <td>
                                            @can('meeting_attendant_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.meeting-attendants.show', $meetingAttendant->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('meeting_attendant_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.meeting-attendants.edit', $meetingAttendant->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('meeting_attendant_delete')
                                                <form action="{{ route('frontend.meeting-attendants.destroy', $meetingAttendant->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('meeting_attendant_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.meeting-attendants.massDestroy') }}",
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
    pageLength: 25,
  });
  let table = $('.datatable-MeetingAttendant:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection