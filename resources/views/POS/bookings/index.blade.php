@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <!-- Start page title -->
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
    </div>

    <div class="row mt-3">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle" id="example">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Guest</th>
                                <th>Room No/s</th>
                                <th>Room Facility Type</th>
                                <th>Checkin</th>
                                <th>Checkout</th>
                                <th>No of Adults/Children</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                @php
                                    $room_numbers = [];
                                    $facility_names = [];
                                    foreach ($item->rooms as $room) {
                                        $room_numbers[] = $room->room_no;
                                        $facility_name = \App\Models\RoomFacilities::where(
                                            'id',
                                            $room->RoomFacility_id,
                                        )->value('name');
                                        $facility_names[] = $facility_name;
                                    }
                                    $rooms = implode(', ', $room_numbers);
                                    $facilities = implode(', ', $facility_names);
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-url="{{ route('get-booking-customers') }}"
                                            data-id="{{ $item->customers->id }}" class="show-modal">
                                            {{ $item->customers->name }}
                                        </a>
                                    </td>
                                    <td>{{ $rooms }}</td>
                                    <td>{{ $facilities }}</td>
                                    <td>{{ date_format(new DateTime($item->checkin), $settings->date_format) }}</td>
                                    <td>{{ date_format(new DateTime($item->checkout), $settings->date_format) }}</td>
                                    <td>{{ $item->no_of_adults }} / {{ $item->no_of_children }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        {{-- @if (!$item->trashed())
                                            @can('view rooms')
                                                <a data-url="{{ route('get-booking-rooms') }}" data-id="{{ $item->id }}"
                                                    class="btn btn-primary btn-sm btn-icon text-white show-modal"
                                                    data-bs-toggle="tooltip" title="View Rooms">
                                                    <i class="mdi mdi-room-service"></i>
                                                </a>
                                            @endcan
                                        @endif --}}
                                        @can('view bookings')
                                            <a data-url="{{ route('bookings.show', [$item->id]) }}"
                                                class="btn btn-light btn-sm btn-icon text-dark show-more"
                                                data-bs-toggle="tooltip" title="View">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endcan
                                        @if (!$item->trashed() && $item->status != 'Complete')
                                            @can('edit bookings')
                                                <a href="javascript:void(0)" class="btn btn-info btn-sm btn-icon edit-dates-btn"
                                                    data-booking-id="{{ $item->id }}"
                                                    data-checkin="{{ date('Y-m-d', strtotime($item->checkin)) }}"
                                                    data-checkout="{{ date('Y-m-d', strtotime($item->checkout)) }}"
                                                    data-bs-toggle="tooltip" title="Edit Dates">
                                                    <i class="bi bi-calendar"></i>
                                                </a>
                                                <a href="javascript:void(0)"
                                                    data-url="{{ route('bookings.edit', [$item->id]) }}"
                                                    class="btn btn-secondary btn-sm btn-icon" data-bs-toggle="modal"
                                                    data-bs-target="#editBookingModal" data-bs-toggle="tooltip"
                                                    title="Add Cancellation Reason">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                            @endcan
                                            @can('delete bookings')
                                                <a href="javascript:void(0)"
                                                    data-url="{{ route('bookings.destroy', [$item->id]) }}"
                                                    class="btn btn-danger btn-sm btn-icon delete_confirm"
                                                    data-bs-toggle="tooltip" title="Cancel Booking">
                                                    <i class="bi bi-x"></i>
                                                </a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Dates Modal -->
    <div class="modal fade" id="editDatesModal" tabindex="-1" aria-labelledby="editDatesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDatesModalLabel">Edit Booking Dates</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDatesForm">
                        @csrf
                        <input type="hidden" id="bookingId" name="booking_id">
                        <div class="form-group mb-3">
                            <label for="checkinDate">Check-in Date</label>
                            <input type="date" class="form-control" id="checkinDate" name="checkin_date" required>
                        </div>
                        <div class="form-group">
                            <label for="checkoutDate">Check-out Date</label>
                            <input type="date" class="form-control" id="checkoutDate" name="checkout_date" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveDatesBtn">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookingModalLabel">Cancel Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="editBookingField"
                        placeholder="Reason for cancellation">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmEditBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('bookings.view-customers-rooms-modal')

@section('script')
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Show modal for customers/rooms
            $(document).on('click', '.show-modal', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                var id = $(this).data('id');
                $.ajax({
                    url: url,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id
                    },
                    success: function(result) {
                        $('.custRoomBody').html(result);
                        $('#viewCustomersRoomsModal').modal('show');
                    },
                    error: function(xhr) {
                        toastr.error('Failed to load data');
                    }
                });
            });

            // Edit dates modal
            $(document).on('click', '.edit-dates-btn', function() {
                var bookingId = $(this).data('booking-id');
                var checkinDate = $(this).data('checkin');
                var checkoutDate = $(this).data('checkout');

                $('#bookingId').val(bookingId);
                $('#checkinDate').val(checkinDate);
                $('#checkoutDate').val(checkoutDate);

                $('#editDatesModal').modal('show');
            });

            // Save dates

            // Save dates
            $(document).on('click', '#saveDatesBtn', function() {
                var bookingId = $('#bookingId').val();
                var checkinDate = $('#checkinDate').val();
                var checkoutDate = $('#checkoutDate').val();

                if (!checkinDate || !checkoutDate) {
                    alert('Please fill in both dates');
                    return;
                }

                if (new Date(checkoutDate) <= new Date(checkinDate)) {
                    alert('Check-out date must be after check-in date');
                    return;
                }

                $.ajax({
                    url: '{{ route('bookings.updateDates') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        booking_id: bookingId, // Changed from 'id' to 'booking_id'
                        checkin_date: checkinDate,
                        checkout_date: checkoutDate
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Dates updated successfully');
                        $('#editDatesModal').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON); // Log validation errors
                        toastr.error(xhr.responseJSON?.message || 'An error occurred');
                    }
                });
            });



            // Cancel booking
            $(document).on('click', '#confirmEditBtn', function() {
                var bookingId = $(this).data('booking-id');
                var cancelReason = $('#editBookingField').val();

                if (!cancelReason) {
                    toastr.error('Please enter a cancellation reason');
                    return;
                }

                $.ajax({
                    url: '/update-booking-cancel-reason/' + bookingId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: bookingId,
                        cancel_reason: cancelReason
                    },
                    beforeSend: function() {
                        $('#confirmEditBtn').prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...'
                        );
                    },
                    success: function(response) {
                        toastr.success(response.message || 'Booking cancelled successfully');
                        $('#editBookingModal').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message || 'An error occurred');
                    },
                    complete: function() {
                        $('#confirmEditBtn').prop('disabled', false).text('Save changes');
                    }
                });
            });

            // Delete booking
            $(document).on('click', '.delete_confirm', function(e) {
                e.preventDefault();
                var url = $(this).data('url');

                if (confirm('Are you sure you want to cancel this booking?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            toastr.success(response.message ||
                            'Booking cancelled successfully');
                            window.location.reload();
                        },
                        error: function(xhr) {
                            toastr.error(xhr.responseJSON?.message || 'An error occurred');
                        }
                    });
                }
            });
        });
    </script>
@endsection
