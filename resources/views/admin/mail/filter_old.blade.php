@extends('layouts.admin')
@section('content')
<form action = "{{ url('admin/filterset') }}" method = "post" enctype="multipart/form-data">
{{ csrf_field() }}
    <div class="container">
        <div class="form-group">
            <input class="form-control" type="text" name="mailto" value="{{$filters[0]->mailto}}"/>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="terms" {{$filters[0]->filter1 ? 'checked' : '' }} />
            <label>Don't Forward Empty Mail</label>
        </div>
        <div class="form-group">
            <button class="btn btn-success" type="submit">Submit</button>
        </div>
</form>
@endsection

