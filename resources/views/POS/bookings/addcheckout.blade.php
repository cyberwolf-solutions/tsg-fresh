@extends('layouts.master')

@section('title')
    {{ $title }}
@endsection
@section('content')
    <!-- start page title -->
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
                <form method="POST" class="ajax-form" action="{{ route('checkout.store') }}">
                    @csrf
                    {{-- @if ($is_edit)
                    @method('PATCH')
                    @endif --}}

                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Customer Name</label>
                            <select name="customer_id" class="form-control js-example-basic-single" id="customer-select"
                                required>
                                <option value="">Select...</option>
                                @php
                                    $seenCustomerIds = [];
                                @endphp

                                @foreach ($data as $record)
                                    @if ($record->customer && !in_array($record->customer->id, $seenCustomerIds))
                                        @php
                                            $seenCustomerIds[] = $record->customer->id;
                                        @endphp
                                        <option value="{{ $record->customer->id }}"
                                            data-email="{{ $record->customer->email }}">
                                            {{ $record->customer->name }}
                                        </option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Booking Rooms</label>
                            <select name="booking_room_id" class="form-control" id="booking-room-select" required>
                                <option value="">Select...</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Booking Id</label>
                            <input type="text" name="booking_id" id="booking_id" class="form-control"
                                placeholder="Booking ID" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Room Facility</label>
                            <input type="text" name="room_facility" id="room-facility" class="form-control"
                                placeholder="Room Facility" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Room No</label>
                            <input type="text" name="room_no" id="room-no" class="form-control" value=""
                                placeholder="Enter Room No" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Check In Date</label>
                            <input type="text" name="checkin" id="checkin" class="form-control" value=""
                                placeholder="Check In Date" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Check Out Date</label>
                            <input type="text" name="checkout" id="checkout" class="form-control" value=""
                                placeholder="Check In Date" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Total ammount 1</label>
                            <input type="text" name="total" id="total" class="form-control" value=""
                                placeholder="Total" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Payed amount </label>
                            <input type="text" name="payed" id="payed" class="form-control" value=""
                                placeholder="Payed" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Due amount</label>
                            <input type="text" name="due" id="due" class="form-control" value=""
                                placeholder="Due" required readonly />
                        </div>

                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Restaurant payments</label>
                            <input type="text" name="additional" id="additional" class="form-control" value=""
                                placeholder="Additional" required readonly />
                        </div>

                        <div class="col-md-6 mb-3 ">
                            <label for="additional" class="form-label">Note</label>
                            <textarea name="note" id="note" class="form-control" placeholder="Additional"></textarea>
                        </div>

                        <div class="col-md-6 mb-3 d-none required">
                            <label for="" class="form-label">Full due ammount</label>
                            <input type="text" name="fd" id="fd" class="form-control" value=""
                                placeholder="Full due" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 d-none  required">
                            <label for="" class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control"
                                placeholder="email" required readonly />
                        </div>

                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Total Hotel Charge</label>
                            <input type="text" name="tot" id="tot" class="form-control" value=""
                                placeholder="Ammount" required readonly />
                        </div>

                        <div class="row mb-4 col-md-6">
                            <label for="">Additional Services</label>
                            <select name="ingredient" id="ingredient" class="form-control js-example-basic-single">
                                <option value="">Select...</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="required mt-2 col-md-12">
                            <div class="row mb-4 px-3">
                                <table class="table table-hover align-middle" id="ingredient_tbl">
                                    <thead class="table-light">
                                        <th>Service</th>
                                        {{-- <th>Description</th> --}}
                                        <th>Price</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="1"></th>
                                            <th>Total</th>
                                            <th> <span class="total"></span></th>
                                            <th colspan="2">&nbsp;</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Total ammmount</label><span id="currency-th"></span>
                            <input type="text" name="ftot" id="ftot" class="form-control" value=""
                                placeholder="Ammount" required readonly />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Currency</label><span id="currencytype"></span>
                            <input type="text" name="ctype" id="ctype" class="form-control" value=""
                                placeholder="Ammount" required readonly />
                        </div>

                        <input type="hidden" name="checkincheckout_id" id="checkincheckout_id" readonly>

                    </div>

                    <input type="hidden" name="table_data" id="table_data">

                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('checkout.index') }}'">Cancel</button>
                            <button class="btn btn-primary" type="submit">Create</button>
                        </div>
                    </div>
                </form>
                {{-- <button class="btn btn-secondary">Print</button> --}}
            </div>
        </div>

    </div>





    <div id="response"></div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        $(document).ready(function() {
            $('.ajax-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                let $form = $(this);
                let formData = new FormData(this); // Use FormData for file/data support

                $.ajax({
                    url: $form.attr('action'),
                    type: $form.attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success && response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            alert('Success, but no redirect provided.');
                            console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Status:", status);
                        console.error("Error:", error);
                        console.error("Response:", xhr.responseText);

                        let msg = 'An error occurred:\n\n';

                        // Laravel validation errors
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            msg += xhr.responseJSON.errors.join('\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg += xhr.responseJSON.message;
                        } else {
                            msg += xhr.responseText;
                        }

                        alert(msg);
                    }
                });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var customerSelect = document.getElementById('customer-select');
            var emailInput = document.getElementById('email');
            var emailContainer = document.getElementById('email-container');

            customerSelect.addEventListener('change', function() {
                var selectedOption = customerSelect.options[customerSelect.selectedIndex];
                var email = selectedOption.getAttribute('data-email');

                if (email) {
                    emailInput.value = email;
                    emailContainer.classList.remove('d-none');
                } else {
                    emailInput.value = '';
                    emailContainer.classList.add('d-none');
                }
            });
        });

        $(document).ready(function() {
            // updateTotalAmount();
            $('#customer-select').change(function() {
                var customerId = $(this).val();

                // Send AJAX request to fetch booking rooms
                $.ajax({
                    url: '/get-booking-rooms/' + customerId,
                    type: 'GET',
                    success: function(response) {
                        // alert(JSON.stringify(response));
                        $('#booking-room-select').empty();
                        $('#responseContainer').html(JSON.stringify(response));


                        $('#booking-room-select').append($('<option>', {
                            value: '',
                            text: 'Select Room',
                            disabled: true,
                            selected: true, // Optionally keep it selected by default
                            // hidden: true // Optionally hide it from the dropdown
                        }));

                        // Update the currency symbol
                        if (response.currency) {
                            $('#currency-th').text(response.currency.name);
                        }


                        if (response.bookings.length > 0) {
                            $.each(response.bookings, function(index, booking) {
                                $.each(booking.rooms, function(index, room) {
                                    $('#booking-room-select').append($(
                                        '<option>', {
                                            value: room.id,
                                            text: room.room_no,
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
                                                .price_usd,
                                            'data-price-eu': room
                                                .price_eu
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


            $(document).ready(function() {
                $('#booking-room-select').change(function() {
                    var customerId = $('#customer-select').val();
                    var bookingId = $('#booking_id').val();
                    var roomno = $('#room-no').val();

                    // alert(roomno);


                    // Send AJAX request to fetch checkincheckout ID
                    $.ajax({
                        url: '/get-checkincheckout-id',
                        type: 'GET',
                        data: {
                            customer_id: customerId,
                            booking_id: bookingId,
                            roomno: roomno

                        },
                        success: function(response) {
                            $('#checkincheckout_id').val(response.checkincheckout_id);
                            // alert(JSON.stringify(response));
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
            // var pvalue;






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


            $('#booking-room-select').change(function() {
                var Id = $(this).find(':selected').data('id');
                $('#booking_id').val(Id);
            });


            function updateFinalTotal() {
                var additionalServicesTotal = parseFloat($(".total").text()) || 0;
                var hotelChargeTotal = parseFloat($('#tot').val()) || 0;
                var finalTotal = additionalServicesTotal + hotelChargeTotal;
                $('#ftot').val(finalTotal.toFixed(2));
            }



            $('#booking-room-select').change(function() {
                var bookingId = $('#booking_id').val();

                // Send AJAX request to fetch paid and due amounts for the selected booking
                $.ajax({
                    url: '/get-booking-payment-details/' + bookingId,
                    type: 'GET',
                    success: function(response) {
                        $('#payed').val(response.payed);
                        $('#due').val(response.due);
                        $('#total').val(response.total_amount);
                        // Show currency name in span and input
                        $('#currencytype').val(response.currencytype); // <span>
                        $('#ctype').val(response.currencytype); // <input>

                        calculateDue();
                        calculateFullDue();
                        updateFinalTotal();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


            $('#booking-room-select').change(function() {
                var roomNo = $(this).find(':selected').data('room-no');
                $('#room-no').val(roomNo);
            });
            $('#booking-room-select').change(function() {
                var totalAmount = $(this).find(':selected').data('total_amount');
                var totalAmount1 = $(this).find(':selected').data('price-usd');
                var totalAmount2 = $(this).find(':selected').data('price-eu');
                var currency = $('#currency-th').text().trim();
                if (currency === 'USD') {
                    $('#total').val(totalAmount1);

                }
                if (currency === 'LKR') {
                    $('#total').val(totalAmount);
                }
                if (currency === 'EUR') {
                    $('#total').val(totalAmount2);
                }

                updateFinalTotal();
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


            $(document).ready(function() {



                $('#payed').on('input', function() {

                });



            });


            $('#customer-select').change(function() {
                var customerId = $(this).val();


                $.ajax({
                    url: '/get-customer-orders/' + customerId,
                    type: 'GET',
                    success: function(response) {

                        var unpaidOrders = response.unpaidOrders;

                        // alert(unpaidOrders);

                        var totalSum = 0;

                        var unpaidOrdersDetails = '';
                        if (unpaidOrders.length > 0) {

                            unpaidOrders.forEach(function(order) {
                                var amount = parseFloat(order.total);
                                totalSum += amount;
                            });

                            unpaidOrdersDetails = totalSum;
                        }



                        $('#additional').val(totalSum);





                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


            function calculateDue() {
                var total = parseFloat($('#total').val()) || 0;
                var payed = parseFloat($('#payed').val()) || 0;
                var due = total - payed;



                $('#due').val(due.toFixed(2));





            }

            // Function to calculate full due amount
            function calculateFullDue() {
                var additional = parseFloat($('#additional').val()) || 0;

                var due = parseFloat($('#due').val()) || 0;
                var fullDue = additional + due;

                $('#fd').val(fullDue.toFixed(2));
                $('#tot').val(fullDue.toFixed(2));



            }




            $(document).on('click', '.remove_row', function(e) {
                e.preventDefault();
                var id = $(this).closest('tr').find('.ing_id').val();
                var name = $(this).closest('tr').find('span.iname').text();
                $(this).closest("tr").remove();
                $("#ingredient").append('<option value="' + id + '">' + name + '</option>');
                getTotal();
            });

            function getTotal() {
                var sum = 0;
                $('.cost').each(function() {
                    sum += +$(this).text() || 0;
                });
                $(".total").text(sum.toFixed(2));
            }

            $(document).ready(function() {
                $('#ingredient').change(function() {
                    var selectedItem = $('#ingredient option:selected');
                    var itemName = selectedItem.text();
                    var itemId = selectedItem.val();
                    // Check if the selected item is not empty
                    if (itemName.trim() !== "") {
                        var newRow = '<tr>' +
                            '<td><span class="iname">' + itemName + '</span></td>' +
                            '<td>' +
                            '<input type="number" step="any" class="form-control bg-transparent price" name="price[]" value="">' +
                            '</td>' +
                            '<td><button class="btn bg-transparent border-0 text-danger remove_row"><i class="ri-delete-bin-2-line"></i></button></td>' +
                            '</tr>';
                        $('#ingredient_tbl tbody').append(newRow);
                        // Remove the selected option from the dropdown
                        selectedItem.remove();

                        updateTotal();
                    }
                });

                $(document).on('click', '.remove_row', function(e) {
                    e.preventDefault();
                    var id = $(this).closest('tr').find('.ing_id').val();
                    var name = $(this).closest('tr').find('span.iname').text();
                    $(this).closest("tr").remove();
                    // Check if the option already exists in the dropdown before adding it back
                    if ($('#ingredient option[value="' + id + '"]').length === 0) {
                        $("#ingredient").append('<option value="' + id + '">' + name + '</option>');
                    }
                    updateTotal();
                });

                $(document).on('input', '.price', function() {
                    updateTotal();
                });

                function updateTotal() {
                    var sum = 0;
                    $('.price').each(function() {
                        sum += parseFloat($(this).val()) || 0;
                    });
                    $(".total").text(sum.toFixed(2));
                    updateFinalTotal();
                }



                $('#tot').on('input', function() {
                    updateFinalTotal();
                });

                // Initial call to ensure the final total is calculated on page load if values are present
                updateFinalTotal();
            });







            $(document).ready(function() {
                // Function to append table data to the form
                function appendTableDataToForm() {
                    var tableData = [];
                    $('#ingredient_tbl tbody tr').each(function(index, row) {
                        var name = $(row).find('.iname').text();
                        var price = $(row).find('input[name="price[]"]').val();
                        if (name.trim() !== "" && price.trim() !== "") {
                            tableData.push({
                                name: name,
                                price: price
                            });
                        }
                    });
                    $('#table_data').val(JSON.stringify(tableData));
                    return tableData;
                }

                // Form submission handler
                $('form.ajax-form').submit(function(event) {
                    event.preventDefault();

                    var form = $(this);
                    var url = form.attr('action');
                    var formData = form.serialize();
                    var roomNo = $('#room-no').val();

                    // alert(roomNo);

                    var tableData = appendTableDataToForm();
                    // alert("Table Data:\n" + JSON.stringify(tableData, null, 2));

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                // Open the invoice in a new tab
                                window.open(response.redirect, '_blank');

                                // Redirect the current page to checkout index
                                window.location.href = '{{ route('checkout.index') }}';
                            } else {
                                console.error(response.errors);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });


        });
    </script>
@endsection
