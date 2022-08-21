@extends('layouts.admin')
@section('content')
<div class="container main-table">
    <div class="row main-row ">
        <div class="col-3 col-md-1">
            <p class="fw-bold ">UID</p>
        </div>
        <div class="col-3 col-md-4">
            <p class="fw-bold ">Subject</p>
        </div>
        <div class="col-3 col-md-5">
            <p class="fw-bold ">{{ request()->is('admin/incoming') ? 'From' : 'To' }}</p>
        </div>
        <div class="col-2 col-md-1">
            <p class="fw-bold ">Attachmens</p>
        </div>
        {{-- <div class="col-1 col-md-1">
            <p class="fw-bold ">Operation</p>
        </div> --}}
    </div>
    @if ($paginator->count() > 0)
        @foreach ($paginator as $oMessage)
            <!-- <a href="{{ request()->url() }}/{{ $oMessage->uid }}/show" class="text-decoration-none link-to-meesage"> -->
                <div class="h-50 row{{ $loop->odd ? ' bg-row' : '' }}">
                    <div
                        class="col-3 col-md-1 align-items-center d-flex py-1 justify-content-center justify-content-xl-start">
                        <a href="{{ request()->url() }}/{{ $oMessage->uid }}/show" class="text-decoration-none link-to-meesage">
                        <p class="fw-light py-0 my-0 uid-number ">{{ $oMessage->uid }}</p>
                        </a>
                    </div>
                    <div class="col-3 col-md-4 align-items-center d-flex py-1">
                        <a href="{{ request()->url() }}/{{ $oMessage->uid }}/show" class="text-decoration-none link-to-meesage">
                        <p class="fw-light py-0 my-0 ">
                            {{ $oMessage->subject }}
                        </p>
                        </a>
                    </div>
                    <div class="col-3 col-md-5 align-items-center d-flex py-1">
                        <a href="{{ request()->url() }}/{{ $oMessage->uid }}/show" class="text-decoration-none link-to-meesage">
                        <p class="fw-light py-0 my-0 ">
                            {{ request()->is('admin/incoming') ? $oMessage->from_email : $oMessage->to_email }}
                        </p>
                        </a>
                    </div>
                    <div
                        class="col-2 col-md-1 align-items-center d-flex py-1 justify-content-center justify-content-xl-start">
                        <a href="{{ request()->url() }}/{{ $oMessage->uid }}/show" class="text-decoration-none link-to-meesage">
                        <p class="fw-light py-0 my-0 ">
                            {{-- {{ $oMessage->getAttachments()->count() > 0 ? 'yes' : 'no' }} --}}
                        </p>
                        </a>
                    </div>
                    {{-- <div
                        class="col-1 col-md-1 align-items-center d-flex py-1">
                        <a href="{{ request()->url() }}/{{ $oMessage->uid }}/forward" class="text-decoration-none link-to-meesage">
                        <button type="button" class="btn btn-success">
                            Forward
                        </button>
                        </a>
                    </div> --}}

                </div>
            <!-- </a> -->
        @endforeach
        {{ $paginator->links() }}
    @else
        <div class="row mt-4 bg-row">
            No messages found
        </div>
    @endif
</div>
@endsection
