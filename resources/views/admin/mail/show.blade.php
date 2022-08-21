@extends('layouts.admin')
@section('content')
<h1 class="">

    {!! $message->subject ? $message->subject : "(No Subject)".'<br />' !!}
</h1>
<div class="bg-white rounded w-75 h-25 m-3 p-3">
    {!! $message->body ? $message->body : $message->bodies["text"] !!}
</div>
<div>
    <?php
        $attach = $isIncoming ? $message->from_attachments : $message->to_attachments;
        $files = preg_split ("/\,/", $attach);
    ?>
    @if(count($files) > 0 && $files[0] != '')
        <h4>Attachments</h4>
        <ul>
        @foreach ( $files as $file)
            <li>{{$file}}</li>
        @endforeach
        </ul>
    @endif
</div>
@endsection
