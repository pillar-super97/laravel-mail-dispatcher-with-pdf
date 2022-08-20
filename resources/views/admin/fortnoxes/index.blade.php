@extends('layouts.admin')
@section('content')
@can('fortnox_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.fortnoxes.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.fortnox.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.fortnox.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Fortnox">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.fortnox.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.fortnox.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.fortnox.fields.client') }}
                        </th>
                        <th>
                            {{ trans('cruds.fortnox.fields.secret') }}
                        </th>
                        <th>
                            {{ trans('cruds.fortnox.fields.access_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.fortnox.fields.access_token') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fortnoxes as $key => $fortnox)
                        <tr data-entry-id="{{ $fortnox->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $fortnox->id ?? '' }}
                            </td>
                            <td>
                                {{ $fortnox->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $fortnox->client ?? '' }}
                            </td>
                            <td>
                                {{ $fortnox->secret ?? '' }}
                            </td>
                            <td>
                                {{ $fortnox->access_code ?? '' }}
                            </td>
                            <td>
                                {{ $fortnox->access_token ?? '' }}
                            </td>
                            <td>
                                @can('fortnox_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.fortnoxes.show', $fortnox->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('fortnox_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.fortnoxes.edit', $fortnox->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('fortnox_delete')
                                    <form action="{{ route('admin.fortnoxes.destroy', $fortnox->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('fortnox_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.fortnoxes.massDestroy') }}",
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
    pageLength: 100,
  });
  let table = $('.datatable-Fortnox:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection