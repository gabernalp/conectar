@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('user_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.users.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'User', 'route' => 'admin.users.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.user.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-User">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.user.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.documenttype') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.document') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.last_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.gender') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.phone') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.phone_2') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.department') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.city') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.zona') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.etnia') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.academic_background') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.min_age') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.max_age') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.devices') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.roles') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.modality') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.newsletter_subscription') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.email_verified_at') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.approved') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.verified') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.operator') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.user.fields.entity') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $key => $user)
                                    <tr data-entry-id="{{ $user->id }}">
                                        <td>
                                            {{ $user->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->documenttype->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->document ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->last_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\User::GENDER_SELECT[$user->gender] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->phone ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->phone_2 ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->department->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->city->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\User::ZONA_SELECT[$user->zona] ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\User::ETNIA_SELECT[$user->etnia] ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\User::ACADEMIC_BACKGROUND_SELECT[$user->academic_background] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->min_age ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->max_age ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($user->devices as $key => $item)
                                                <span>{{ $item->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($user->roles as $key => $item)
                                                <span>{{ $item->title }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ App\User::MODALITY_SELECT[$user->modality] ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $user->newsletter_subscription ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $user->newsletter_subscription ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $user->email_verified_at ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $user->approved ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $user->approved ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $user->verified ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $user->verified ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $user->operator->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $user->entity ?? '' }}
                                        </td>
                                        <td>
                                            @can('user_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.users.show', $user->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('user_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.users.edit', $user->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('user_delete')
                                                <form action="{{ route('frontend.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('user_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.users.massDestroy') }}",
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
  let table = $('.datatable-User:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection