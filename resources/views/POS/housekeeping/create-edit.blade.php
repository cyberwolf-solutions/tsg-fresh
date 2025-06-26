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
                    {{-- <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
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
                <form method="POST" class="ajax-form" action="{{ route('housekeeping.store') }}">
                    @csrf
                    {{-- @if ($is_edit)
                        @method('PATCH')
                    @endif --}}
                    <div class="row">
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{ $data->name }}" placeholder="Enter Name" readonly required />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="" class="form-label">Room No</label>
                            <input type="text" name="roomno" id="roomno" class="form-control"
                                value="{{ $data->room_no }}" placeholder="Enter Name" readonly required />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="st" id="start_time" class="form-control" value="" placeholder="Enter Start Time"  required />
                        </div>
                        <div class="col-md-6 mb-3 required">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="et" id="end_time" class="form-control" value="" placeholder="Enter End Time"  required />
                        </div>

                    </div>

                    <div class="required mt-2">
                        <label for="">Used Item</label>
                        <div class="row mb-4">
                            <select name="ingredient" id="ingredient" class="form-control js-example-basic-single">
                                <option value="">Select...</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-4 px-3">
                            <table class="table table-hover align-middle" id="ingredient_tbl">
                                <thead class="table-light">
                                    <th>Name</th>
                                    <th>Used Quantity</th>
                                    <th>Remove</th>
                                </thead>
                                <tbody>

                                    <tr>
                                        {{-- <td><span class="iname"></span></td>
                                        <td>
                                            <input type="number" step="any" class="form-control bg-transparent"
                                                id="quantity" name="quantity[]"
                                                value="">
                                        </td>
                                        <td><button class="btn bg-transparent border-0 text-danger remove_row"><i
                                                    class="ri-delete-bin-2-line"></i></button></td> --}}
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('housekeeping.index') }}'">Cancel</button>
                            <button class="btn btn-primary">{{ 'Finish Housekeeping' }}</button>
                        </div>
                    </div>
                    <input type="hidden" name="table_data" id="table_data">

                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
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
                        '<input type="number" step="any" class="form-control bg-transparent" name="quantity[]" value="">' +
                        '</td>' +
                        '<td><button class="btn bg-transparent border-0 text-danger remove_row"><i class="ri-delete-bin-2-line"></i></button></td>' +
                        '</tr>';
                    $('#ingredient_tbl tbody').append(newRow);
                    // Remove the selected option from the dropdown
                    selectedItem.remove();
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
                getTotal();
            });

            function getTotal() {
                var sum = 0;
                $('.cost').each(function() {
                    sum += +$(this).text() || 0;
                });
                $(".total").text(sum.toFixed(2));
            }
        });



        $(document).ready(function() {
            // Declare tableData variable outside the function
            var tableData;

            // // Function to append table data to form
            // function appendTableDataToForm() {
            //     tableData = []; // Initialize tableData
            //     $('#ingredient_tbl tbody tr').each(function(index, row) {
            //         var name = $(row).find('.iname').text();
            //         var quantity = $(row).find('input[name="quantity[]"]').val();
            //         // Check if both name and quantity are not empty
            //         if (name.trim() !== "" && quantity.trim() !== "") {
            //             tableData.push({
            //                 name: name,
            //                 quantity: quantity
            //             });
            //         }
            //     });
            //     // Set the value of the hidden input field to the JSON stringified table data
            //     $('input[name="table_data"]').val(JSON.stringify(tableData));
            //     return tableData;
            // }


            function appendTableDataToForm() {
                var tableData = [];
                $('#ingredient_tbl tbody tr').each(function(index, row) {
                    var name = $(row).find('.iname').text();
                    var quantity = $(row).find('input[name="quantity[]"]').val();
                    if (name.trim() !== "" && quantity.trim() !== "") {
                        tableData.push({
                            name: name,
                            quantity: quantity
                        });
                    }
                });
                $('#table_data').val(JSON.stringify(tableData));
                return tableData;
            }

            // Event listener for form submission
            $('form.ajax-form').submit(function() {
                // Call the appendTableDataToForm function to gather and append table data
                appendTableDataToForm();

                // alert("Table Data:\n" + JSON.stringify(tableData, null, 2));
            });

            // Event listener for the "Finish Housekeeping" button
            $('.btn-primary').click(function() {
                // Call the appendTableDataToForm function to gather and append table data
                appendTableDataToForm();

                // alert("Table Data:\n" + JSON.stringify(tableData, null, 2));
                // alert("Table Data:\n" + JSON.stringify(tableData, null, 2));
            });
        });
    </script>
@endsection
