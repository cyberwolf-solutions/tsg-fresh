@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <div>
                    <h3 class="mb-sm-0">{{ $title }}</h3>
                    <ol class="breadcrumb m-0 mt-2">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ $breadcrumb['active'] ? 'active' : '' }}">
                                @if (!$breadcrumb['active'])
                                    <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                                @else
                                    {{ $breadcrumb['label'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>

        <div class="col-9">
            <form method="GET" action="" id="filter-form">
                <div class="row p-3">
                    <div class="col-md-3 mb-3">
                        <label for="checkin_date" class="form-label">Check-in Date</label>
                        <input type="date" id="checkin_date" name="checkin_date" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="checkout_date" class="form-label">Check-out Date</label>
                        <input type="date" id="checkout_date" name="checkout_date" class="form-control" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end mb-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>

                </div>
            </form>
        </div>

        <div class="col-md-2 mb-3">
            <div class="row p-3 ">
                <label for="room_type" class="form-label">Room Status</label>
                <select id="room_type" name="room_type" class="form-control" onchange="filterRooms()">
                    <option value="">All</option>
                    <option value="Available">Available</option>
                    <option value="Reserved">Reserved</option>
                    <option value="Ongoing">Ongoing</option>
                    <option value="Cleaning">Cleaning</option>
                </select>
            </div>
        </div>
        <div class="col-1 ">
            <div class="row p-3">
                <label for="room_type" class="form-label">*</label>
                <a href="{{ route('status') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>


        <div class="align-items-center justify-content-between">
            <div id="room-display">
                <div class="row p-3">
                    <div class="col-sm-12 col-lg-12 mb-3">
                        <div class="row">
                            @foreach ($data as $data1)
                                {{-- <div class="col-lg-4 col-sm-12"> --}}
                                <div class="col-lg-4 col-sm-12 room" data-status="{{ $data1->status }}">
                                    <div class="position-relative d-flex justify-content-center">
                                        <div class="hotel-image shadow rounded border border-3 shadow-lg">
                                            <img src="{{ asset('uploads/rooms/' . $data1->image_url) }}" class="image-inner"
                                                style="height: 300px; width: 250px; border-radius: 5px;" alt="">
                                        </div>
                                        <div
                                            class="scroll-bar overlay-black px-4 py-3 text-center text-white position-absolute">
                                            <h2 class="fs-21 mt-3 font-weight-bold">
                                                {{ $data1->name }}</h2>
                                            <h3 class="fs-21 mt-3 font-weight-bold">
                                                Room No : {{ $data1->room_no }}</h3>
                                            <p class="mb-1">
                                                Occupancy : {{ $data1->capacity }}</p>
                                            @foreach ($type as $roomType)
                                                @if ($roomType->id == $data1->type)
                                                    <p class="mb-1">{{ $roomType->name }}</p>
                                                @endif
                                            @endforeach

                                            @php
                                                $buttonClass = '';
                                                switch ($data1->status) {
                                                    case 'Available':
                                                        $buttonClass = 'btn-success';
                                                        break;
                                                    case 'Reserved':
                                                        $buttonClass = 'btn-danger';
                                                        break;
                                                    case 'Ongoing':
                                                        $buttonClass = 'btn-warning';
                                                        break;
                                                    case 'Cleaning':
                                                        $buttonClass = 'btn-primary';
                                                        break;
                                                    default:
                                                        $buttonClass = 'btn-secondary';
                                                }
                                            @endphp

                                            <button type="button" class="btn {{ $buttonClass }} mb-2 font-weight-bold"
                                                id="" value="130100" data-toggle="modal"
                                                data-target="#exampleModal1"
                                                fdprocessedid="ac7aon">{{ $data1->status }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function filterRooms() {
            var roomStatus = document.getElementById('room_type').value;
            var rooms = document.getElementsByClassName('room');

            for (var i = 0; i < rooms.length; i++) {
                var room = rooms[i];
                if (roomStatus === '' || room.getAttribute('data-status') === roomStatus) {
                    room.style.display = 'block';
                } else {
                    room.style.display = 'none';
                }
            }
        }
    </script>
@endsection
