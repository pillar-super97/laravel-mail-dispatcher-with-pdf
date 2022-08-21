@extends('layouts.admin')
@section('content')
<div class="container main-table">
    <div class="row main-row ">
        <div class="col-3 col-md-6">
            <p class="fw-bold ">Address</p>
        </div>
        <div class="col-3 col-md-3">
            <p class="fw-bold ">Count</p>
        </div>
        <div class="col-2 col-md-3">
            <p class="fw-bold ">Recieve</p>
        </div>
    </div>
    @if ($paginator->count() > 0)
        @foreach ($paginator as $address)
                <div class="h-50 row{{ $loop->odd ? ' bg-row' : '' }}">
                    <div
                        class="col-3 col-md-6 align-items-center d-flex py-1 justify-content-center justify-content-xl-start">
                        <p class="fw-light py-0 my-0 uid-number ">{{ $address->address }}</p>
                        </a>
                    </div>
                    <div class="col-3 col-md-3 align-items-center d-flex py-1">
                        <p class="fw-light py-0 my-0 ">
                            {{ $address->count }}
                        </p>
                        </a>
                    </div>
                    <div
                        class="col-1 col-md-3 align-items-center d-flex py-1">
                        <label class="checkbox-inline">
                            <input type="checkbox"  data-toggle="toggle"
                                class="toggle-event"
                                {{-- data-onstyle="primary" data-offstyle="danger" --}}
                                data-on="<i class='fa fa-play'></i> Allow"
                                data-off="<i class='fa fa-stop'></i> Deny"
                                {{ $address->state ? 'checked' : '' }}
                                value = {{$address->state}}
                                address = {{$address->address}}
                            >
                        </label>
                        </a>
                    </div>

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

@section('scripts')

    <script>
        $(document).ready(function() {
            $('.toggle-event').change(function() {
                $toggle = $(this);
                $state = $toggle.attr("value");
                $.ajax({
                    url: '/admin/address-set',
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        address : $(this).attr("address"),
                        state : 1 - Number($state)
                    },
                    success: function(success) {
                        $toggle.attr("value", success);
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            })
        })
    </script>
@endsection
