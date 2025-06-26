@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection
@section('content')
    <!-- start page title -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

                <div class="page-title-right">
                    {{-- Add Buttons Here --}}
                    {{-- <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
                        title="Create">
                        <i class="ri-add-line fs-5"></i>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="card">
            <div class="card-body">
                <form method="POST" class="ajax-form" action="{{ route('checkin.store') }}">
                    @csrf
                    @if ($is_edit)
                        @method('PATCH')
                    @endif
                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Customer Name</label>
                            <select name="customer_id" class="form-control js-example-basic-single" id="customer-select"
                                required>

                                <option value="">Select...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 ">
                            <label for="" class="form-label">Booking Rooms</label>
                            <select name="booking_room_id" class="form-control" id="booking-room-select" required>
                                <option value="">Select...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Booking Id</label>
                            <input type="text" name="booking_id" id="booking_id" class="form-control"
                                placeholder="Room Facility" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required d-none">
                            <label for="" class="form-label">Room Facility</label>
                            <input type="text" name="room_facility" id="room-facility" class="form-control"
                                placeholder="Room Facility" readonly />
                        </div>
                        <div class="col-md-6 mb-3 required d-none">
                            <label for="" class="form-label">Room No</label>
                            <input type="text" name="room_no" id="room-no" class="form-control"
                                value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Enter Room No" readonly />
                        </div>
                         <div class="col-md-6 mb-3 required d-none">
                            <label for="" class="form-label">Room Type</label>
                            <input type="text" name="room_type" id="room-type" class="form-control"
                                value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Enter Room No" readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Check In Date</label>
                            <input type="text" name="checkin" id="checkin" class="form-control"
                                value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Check In Date" required
                                readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Check Out Date</label>
                            <input type="text" name="checkout" id="checkout" class="form-control"
                                value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Check In Date" required
                                readonly />
                        </div>
                        <div class="col-md-6 mb-3 required d-none">
                            <label for="" class="form-label">Room Price For One Day (LKR.)</label>
                            <input type="text" name="total1" id="total1" class="form-control"
                                value="{{ $is_edit ? $data->total_lkr : '' }}" placeholder="Total" readonly />
                        </div>
                        <div class="col-md-6 mb-3 required d-none ">
                            <label for="" class="form-label">Total ammount for the days (LKR.)</label>
                            <input type="text" name="total" id="total" class="form-control"
                                value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Total" readonly />
                        </div>

                       
                    </div>

                    <div class="row mb-4 px-3">
                        <table class="table table-hover align-middle" id="ingredient_tbl">
                            <thead class="table-light">
                                <th>Room No</th>
                                <th>Facility</th>
                                <th># Nights</th>
                                <th>Price per night</th>
                                <th>Totalß</th>
                                <th>Paying Ammount</th>
                                <th>Due</th>
                                <th>Remove</th>
                            </thead>
                            <tbody>

                              
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2"></th>
                                    <th>Total</th>
                                    <th><span id="currency-th"></span> <span
                                            class="total">{{ $is_edit ? $total : '0.00' }}</span></th>
                                    <th colspan="2">&nbsp;</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <input type="hidden" name="table_data" id="table_data">

                    <div class="col-md-6 mb-3 required d-show">
                        <label for="" class="form-label">Payed ammount (LKR.)</label>
                        <input type="text" name="payed" id="payed" class="form-control"
                            value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Payed" />
                    </div>
                    <div class="col-md-6 mb-3 required d-show">
                        <label for="" class="form-label">Due ammount (LKR.)</label>
                        <input type="text" name="due" id="due" class="form-control"
                            value="{{ $is_edit ? $data->room_no : '' }}" placeholder="Due" readonly />
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('rooms.index') }}'">Cancel</button>
                            <button class="btn btn-primary">{{ $is_edit ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- <div id="responseContainer"></div> --}}


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let selectedCurrency = '';
        $(document).ready(function() {

            $('#customer-select').change(function() {
                var customerId = $(this).val();

                // Send AJAX request to fetch booking rooms and currency
                $.ajax({
                    url: '/get-booking-rooms/' + customerId,
                    type: 'GET',
                    success: function(response) {
                        // alert(JSON.stringify(response));
                        $('#booking-room-select').empty();
                        $('#responseContainer').html(JSON.stringify(response));

                        // $('#booking-room-select').append($('<option>', {
                        //     value: '',
                        //     text: 'Select Room'
                        // }));
                        $('#booking-room-select').append($('<option>', {
                            value: '',
                            text: 'Select Room',
                            disabled: true,
                            selected: true, // Optionally keep it selected by default
                            // hidden: true // Optionally hide it from the dropdown
                        }));

                        // Update the currency symbol
                        if (response.currency) {
                            selectedCurrency = response.currency; // store it
                            $('#currency-th').text(response.currency); // optional display
                        }


                        if (response.bookings.length > 0) {
                            $.each(response.bookings, function(index, booking) {
                                $.each(booking.rooms, function(index, room) {
                                    $('#booking-room-select').append($(
                                        '<option>', {
                                            value: room.id,
                                            text: room.room_no,
                                            'data-room-type':room.name,
                                            'data-total-ammount': room
                                                .price,
                                            'data-room-no': room
                                                .room_no,
                                            'data-facility-id': room
                                                .RoomFacility_id,
                                            'data-checkin': booking
                                                .checkin,
                                            'data-checkout': booking
                                                .checkout,
                                            'data-id': booking
                                                .id,
                                            'data-price-usd': room
                                                .total_lkr,
                                            'data-price-eu': room
                                                .total_lkr,
                                            'data-relevant-price': booking
                                                .relevant_price
                                        }));
                                });
                            });
                        } else {
                            // If no booking rooms found
                            $('#booking-room-select').append($('<option>', {
                                value: '',
                                text: 'No booking rooms available'
                            }));
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


            // Event listener to remove a room from the table
            $(document).on('click', '.remove-room', function() {
                $(this).closest('tr').remove();
                updateTotal();
                // if ($('#booking-room-select option[value=""]').length === 0) {
                $('#booking-room-select').prepend($('<option>', {
                    value: '',
                    text: 'Select Room',
                    disabled: true,
                    selected: true, // Optionally keep it selected by default
                    hidden: true // Optionally hide it from the dropdown
                }));
                // }
            });


            $('#booking-room-select').change(function() {
                var facilityId = $(this).find(':selected').data('facility-id');

                // Send AJAX request to fetch room facility
                $.ajax({
                    url: '/get-room-facility/' + facilityId,
                    type: 'GET',
                    success: function(response) {
                        $('#room-facility').val(response.name);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


            $(document).ready(function() {
                // Event listener for input changes in paying amount fields
                $(document).on('input', '.paying-amount', function() {
                    var row = $(this).closest('tr');

                    // Get the total price (column index 4, which contains the "price per night" * number of days)
                    var totalText = row.find('td:eq(4)').text();
                    var total = parseFloat(totalText.replace(/[^\d.-]/g, '')) || 0;

                    // Get the paying amount entered by the user
                    var payingAmount = parseFloat($(this).val()) || 0;

                    // Calculate the due amount
                    var due = total - payingAmount;

                    // Update the due column (column index 6) with the calculated due
                    var currency = totalText.split(' ')[0]; // Extract currency (e.g., "LKR")
                    row.find('td:eq(6)').text(currency + ' ' + due.toFixed(2));

                    // Recalculate the total at the bottom (footer)
                    updateTotal();
                });
            });


            function updateTotal() {
                var totalPrice = 0;
                var totalPayed = 0;
                var currency = '';

                $('#ingredient_tbl tbody tr').each(function() {
                    var totalText = $(this).find('td:eq(4)').text().trim();
                    var total = parseFloat(totalText.replace(/[^\d.-]/g, '')) || 0;
                    totalPrice += total;

                    var payingAmount = parseFloat($(this).find('.paying-amount').val()) || 0;
                    totalPayed += payingAmount;

                    if (!currency) {
                        currency = totalText.split(' ')[0]; // Capture once
                    }
                });

                var totalDue = totalPrice - totalPayed;

                // Display currency total in table footer (if you use it)
                $('.total').text(currency + ' ' + totalPrice.toFixed(2));

                // ✅ Update hidden form inputs
                $('#total').val(totalPrice.toFixed(2));
                $('#payed').val(totalPayed.toFixed(2));
                $('#due').val(totalDue.toFixed(2));
            }



            $('#booking-room-select').change(function() {
                var Id = $(this).find(':selected').data('id');
                $('#booking_id').val(Id);
            });
            $('#booking-room-select').change(function() {
                var roomNo = $(this).find(':selected').data('room-no');
                $('#room-no').val(roomNo);
            });
            $('#booking-room-select').change(function() {
                var roomType = $(this).find(':selected').data('room-type');
                $('#room-type').val(roomType);
            });
            $('#booking-room-select').change(function() {
                var totalAmount = $(this).find(':selected').data('booking.relevant_price');
                $('#total1').val(totalAmount);
            });

            $('#booking-room-select').change(function() {
                var usd = $(this).find(':selected').data('total_lkr');
                $('#usd').val(usd);
            });

            $('#booking-room-select').change(function() {
                var euro = $(this).find(':selected').data('total_lkr');
                $('#euro').val(euro);
            });
            $('#booking-room-select').change(function() {
                var checkinDate = $(this).find(':selected').data('checkin');
                // alert('Check-in Date:', checkinDate);
                $('#checkin').val(checkinDate);
            });
            $('#booking-room-select').change(function() {
                var checkiOutDate = $(this).find(':selected').data('checkout');
                // alert('Check-in Date:', checkinDate);
                $('#checkout').val(checkiOutDate);
            });


            $('#booking-room-select').change(function() {
                var selected = $('#booking-room-select :selected');
                var roomNo = selected.data('room-no');
                var roomType = selected.data('room-type');
                var facility = $('#room-facility').val();
                var currency = $('#currency-th').text().trim(); // e.g., USD, LKR, EUR
                var pricePerDay = parseFloat(selected.data('relevant-price'));

                // Calculate number of nights
                var checkinDate = selected.data('checkin');
                var checkoutDate = selected.data('checkout');
                var checkin = new Date(checkinDate);
                var checkout = new Date(checkoutDate);
                var differenceDays = (checkout - checkin) / (1000 * 60 * 60 * 24);
                var night = Math.round(differenceDays); // number of nights

                var totalPrice = pricePerDay * night;

                var payingAmount = ''; // Initially empty
                var due = totalPrice;

                // Construct the row with currency shown before the price
                var newRow = '<tr>' +
                    '<td>' + roomNo + '</td>' +
                    '<td>' + facility + '</td>' +
                    '<td>' + night + '</td>' +
                    '<td>' + currency + ' ' + pricePerDay.toFixed(2) + '</td>' +
                    '<td>' + currency + ' ' + totalPrice.toFixed(2) + '</td>' + // total price
                    '<td><input type="text" class="form-control paying-amount" name="paying_amount[]" value="' +
                    payingAmount + '" placeholder="Enter Paying Amount"></td>' +
                    '<td>' + currency + ' ' + due.toFixed(2) + '</td>' +
                    '<td><button type="button" class="btn btn-danger remove-room"><i class="ri-delete-bin-2-line"></i></button></td>' +
                    '</tr>';

                $('#ingredient_tbl tbody').append(newRow);
                updateTotal();
            });




            $(document).ready(function() {
                // Function to calculate due amount
                function calculateDue() {
                    var total = parseFloat($('#total').val());
                    var payed = parseFloat($('#payed').val());

                    var due = total - payed;

                    $('#due').val(due.toFixed(2));
                }


                $('#payed').on('input', function() {
                    calculateDue();
                });


                // calculateDue();
            });



            $('#booking-room-select').change(function() {
                var totalAmountPerDay = parseFloat($(this).find(':selected').data('total-ammount'));
                var checkinDate = $(this).find(':selected').data('checkin');
                var checkoutDate = $(this).find(':selected').data('checkout');

                $('#checkin').val(checkinDate);
                $('#checkout').val(checkoutDate);


                var checkin = new Date(checkinDate);
                var checkout = new Date(checkoutDate);


                var differenceMs = checkout - checkin;

                var differenceDays = differenceMs / (1000 * 60 * 60 * 24);

                var totalAmountForDays = totalAmountPerDay * differenceDays;

                // Set the value of the total amount field
                // $('#total').val(totalAmountForDays.toFixed(2));
                $('#total').val(Math.round(totalAmountForDays));




                // alert('The difference between check-in and check-out dates is ' + differenceDays +
                // ' days.');
            });


        });


        function appendTableDataToForm() {
            let tableData = []; // Array to hold the table data

            // Loop through each row in the table
            $('#ingredient_tbl tbody tr').each(function() {
                let row = $(this); // Get the current row

                let roomNo = row.find('td:eq(0)').text().trim(); // Get the room number from the first column
                
                let facility = row.find('td:eq(1)').text().trim(); // Get the facility from the second column

                // Get the price per night (remove currency symbol and parse as number)
                let priceText = row.find('td:eq(3)').text().trim(); // e.g., "LKR 84.00"
                let pricePerNight = parseFloat(priceText.replace(/[^\d.]/g, '')) ||
                0; // Remove non-numeric characters (like LKR)

                // Calculate the total amount based on the price per night and number of nights
                let nightCount = parseInt(row.find('td:eq(2)').text().trim()) ||
                1; // Default to 1 if night count is not set
                let totalAmount = pricePerNight * nightCount;

                // Get the paying amount from the input field (user input)
                let payingAmount = parseFloat(row.find('.paying-amount').val()) || 0;

                // Get the due amount (remove currency symbol and parse as number)
                let dueText = row.find('td:eq(6)').text().trim(); // e.g., "LKR 84.00"
                let dueAmount = parseFloat(dueText.replace(/[^\d.]/g, '')) || 0;

                // Add the cleaned data into the tableData array
                tableData.push({
                    roomNo: roomNo,
                    facility: facility,
                    totalAmount: totalAmount, // Add the calculated total amount
                    payingAmount: payingAmount,
                    dueAmount: dueAmount
                });
            });

            // Convert the table data into a JSON string and add it to the hidden input field
            $('#table_data').val(JSON.stringify({
                data: tableData
            }));
        }

        // Event listener for form submission
        $('form.ajax-form').submit(function() {
            // Call the appendTableDataToForm function to gather and append table data
            appendTableDataToForm();
            // Continue with form submission
            return true;
        });

        // Event listener for "Create" button click
        // $('.btn-primary').click(function() {
        //     // Call the appendTableDataToForm function to gather and append table data
        //     appendTableDataToForm();
        //     // Continue with other actions related to creating the entry
        //     var tableData = JSON.parse($('#table_data').val());
        //     //alert(JSON.stringify(tableData));
        // });
    </script>
@endsection
