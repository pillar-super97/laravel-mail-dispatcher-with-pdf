@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.fortnox.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.fortnoxes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.fortnox.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fortnox.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="client">{{ trans('cruds.fortnox.fields.client') }}</label>
                <input class="form-control {{ $errors->has('client') ? 'is-invalid' : '' }}" type="text" name="client" id="client" value="{{ old('client', '') }}" required>
                @if($errors->has('client'))
                    <span class="text-danger">{{ $errors->first('client') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fortnox.fields.client_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="secret">{{ trans('cruds.fortnox.fields.secret') }}</label>
                <input class="form-control {{ $errors->has('secret') ? 'is-invalid' : '' }}" type="text" name="secret" id="secret" value="{{ old('secret', '') }}" required>
                @if($errors->has('secret'))
                    <span class="text-danger">{{ $errors->first('secret') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fortnox.fields.secret_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="access_code">{{ trans('cruds.fortnox.fields.access_code') }}</label>
                <input class="form-control {{ $errors->has('access_code') ? 'is-invalid' : '' }}" type="text" name="access_code" id="access_code" value="{{ old('access_code', '') }}" required>
                @if($errors->has('access_code'))
                    <span class="text-danger">{{ $errors->first('access_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fortnox.fields.access_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="access_token">{{ trans('cruds.fortnox.fields.access_token') }}</label>
                <input class="form-control {{ $errors->has('access_token') ? 'is-invalid' : '' }}" type="text" name="access_token" id="access_token" value="{{ old('access_token', '') }}">
                @if($errors->has('access_token'))
                    <span class="text-danger">{{ $errors->first('access_token') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.fortnox.fields.access_token_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection