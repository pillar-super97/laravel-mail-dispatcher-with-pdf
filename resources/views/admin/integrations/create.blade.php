@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.integration.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.integrations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="key">{{ trans('cruds.integration.fields.key') }}</label>
                <input class="form-control {{ $errors->has('key') ? 'is-invalid' : '' }}" type="text" name="key" id="key" value="{{ old('key', '') }}" required>
                @if($errors->has('key'))
                    <span class="text-danger">{{ $errors->first('key') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.integration.fields.key_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="secret">{{ trans('cruds.integration.fields.secret') }}</label>
                <input class="form-control {{ $errors->has('secret') ? 'is-invalid' : '' }}" type="text" name="secret" id="secret" value="{{ old('secret', '') }}">
                @if($errors->has('secret'))
                    <span class="text-danger">{{ $errors->first('secret') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.integration.fields.secret_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.integration.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.integration.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="platform_id">{{ trans('cruds.integration.fields.platform') }}</label>
                <select class="form-control select2 {{ $errors->has('platform') ? 'is-invalid' : '' }}" name="platform_id" id="platform_id" required>
                    @foreach($platforms as $id => $platform)
                        <option value="{{ $id }}" {{ old('platform_id') == $id ? 'selected' : '' }}>{{ $platform }}</option>
                    @endforeach
                </select>
                @if($errors->has('platform'))
                    <span class="text-danger">{{ $errors->first('platform') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.integration.fields.platform_helper') }}</span>
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