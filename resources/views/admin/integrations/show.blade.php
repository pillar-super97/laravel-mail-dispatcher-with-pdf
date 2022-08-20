@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.integration.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.integrations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.integration.fields.id') }}
                        </th>
                        <td>
                            {{ $integration->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.integration.fields.key') }}
                        </th>
                        <td>
                            {{ $integration->key }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.integration.fields.secret') }}
                        </th>
                        <td>
                            {{ $integration->secret }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.integration.fields.user') }}
                        </th>
                        <td>
                            {{ $integration->user->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.integration.fields.platform') }}
                        </th>
                        <td>
                            {{ $integration->platform->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.integrations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection