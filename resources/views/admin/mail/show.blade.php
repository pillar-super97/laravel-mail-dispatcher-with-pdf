@extends('layouts.admin')
@section('content')
<h1 class="">

    {!! $message->getSubject() ? $message->getSubject() : "(No Subject)".'<br />' !!}
</h1>
<div class="bg-white rounded w-75 h-25 m-3 p-3">
    {!! $message->getHTMLBody() ? $message->getHTMLBody() : $message->bodies["text"] !!}
</div>
@endsection








