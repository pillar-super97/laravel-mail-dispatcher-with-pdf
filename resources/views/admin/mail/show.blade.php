@extends('layouts.admin')
@section('content')
<h1 class="">

    {!! $message->subject ? $message->subject : "(No Subject)".'<br />' !!}
</h1>
<div class="bg-white rounded w-75 h-25 m-3 p-3">
    {!! $message->body ? $message->body : $message->bodies["text"] !!}
</div>
<div>
    @foreach ( preg_split ("/\,/", request()->is('admin/incoming') ? $message->from_attachments : $message->to_attachments) as $file)
        <h3>{{$file}}</h3>
    @endforeach

</div>
@endsection
