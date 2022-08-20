@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fortnox.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fortnoxes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fortnox.fields.id') }}
                        </th>
                        <td>
                            {{ $fortnox->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fortnox.fields.user') }}
                        </th>
                        <td>
                            {{ $fortnox->user->email ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fortnox.fields.client') }}
                        </th>
                        <td>
                            {{ $fortnox->client }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fortnox.fields.secret') }}
                        </th>
                        <td>
                            {{ $fortnox->secret }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fortnox.fields.access_code') }}
                        </th>
                        <td>
                            {{ $fortnox->access_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fortnox.fields.access_token') }}
                        </th>
                        <td>
                            {{ $fortnox->access_token }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fortnoxes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection