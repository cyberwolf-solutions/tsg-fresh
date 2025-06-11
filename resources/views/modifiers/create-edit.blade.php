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
                    {{-- <a href="{{ route('modifiers.create') }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip"
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
                <form method="POST" class="ajax-form" id="product_form"
                    action="{{ $is_edit ? route('modifiers.update', $data->id) : route('modifiers.store') }}">
                    @csrf
                    @if ($is_edit)
                        @method('PATCH')
                    @endif
                    <div class="row">
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" placeholder="Enter Name" required />
                        </div>
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Unit Price(LKR)</label>
                            <input type="text" name="unit_price" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_lkr : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Unit Price(USD)</label>
                            <input type="text" name="unit_price_usd" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_usd : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Unit Price(EURO)</label>
                            <input type="text" name="unit_price_eu" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_eu : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="" rows="1" placeholder="Enter Description">{{ $is_edit ? $data->description : '' }}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            {{-- <label for="" class="form-label">Categories</label>
                            <select name="categories[]" class="form-control js-example-basic-multiple" id=""
                                multiple="multiple">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit && in_array($item->id, $cat_array) ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select> --}}

                            <label for="">Categories</label>
                            <div class="row mb-4">
                                <select name="categories[]" id="" class="form-control js-example-basic-multiple">
                                    <option value="">Select...</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ $is_edit && in_array($item->id, $cat_array) ? 'selected' : '' }}> 
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="required mt-2">
                        <label for="">Ingredients</label>
                        <div class="row mb-4">
                            <select name="ingredient" id="ingredient" class="form-control js-example-basic-single">
                                <option value="">Select...</option>
                                @foreach ($ingredients as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-4 px-3">
                            <table class="table table-hover align-middle" id="ingredient_tbl">
                                <thead class="table-light">
                                    <th>Name</th>
                                    <th>Available Qty</th>
                                    <th>Consumption Qty</th>
                                    <th width="5%"></th>
                                    <th>Unit Price</th>
                                    <th>Cost</th>
                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                </thead>
                                <tbody>
                                    @if ($is_edit)
                                        @for ($x = 0; $x < count($ing_array); $x++)
                                            <tr>

                                                <td><span class="iname">{{ $ing_array[$x]['name'] }}</span></td>
                                                <td>{{ $ing_array[$x]['avl_qty'] }} {{ $ing_array[$x]['unit'] }}</td>
                                                <td>
                                                    <input type="number" step="any"
                                                        class="form-control bg-transparent consumption_qty " id="quantity"
                                                        name="quantity[]" value="{{ $ing_array[$x]['cons_qty'] }}">
                                                </td>
                                                <td>{{ $ing_array[$x]['unit'] }}</td>
                                                <td>{{ $ing_array[$x]['currency'] }} <span
                                                        class="uprice">{{ $ing_array[$x]['unit_price'] }}</span></td>
                                                <td>{{ $ing_array[$x]['currency'] }} <span
                                                        class="cost">{{ $ing_array[$x]['cost'] }}</span></td>
                                                <td><button class="btn bg-transparent border-0 text-danger remove_row"><i
                                                            class="ri-delete-bin-2-line"></i></button></td>
                                                <td><input type="hidden" step="any"
                                                        class="form-control bg-transparent ing_id"
                                                        value="{{ $ing_array[$x]['id'] }}" name="ing_id[]"></td>
                                            </tr>
                                        @endfor
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4"></th>
                                        <th>Total</th>
                                        <th>{{ $settings->currency }} <span
                                                class="total">{{ $is_edit ? $total : '0.00' }}</span></th>
                                        <th colspan="2">&nbsp;</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('modifiers.index') }}'">Cancel</button>
                            <button class="btn btn-primary"
                                onclick="sendDataToServer()">{{ $is_edit ? 'Update' : 'Create' }}</button>
                        </div>
                    </div>
                    <input type="hidden" id="table_data_input" name="table_data">
                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $("#ingredient").change(function(e) {
            e.preventDefault();
            var el = $(this);
            var ing_id = el.val();
            $.ajax({
                url: '{{ route('get-ingredients') }}',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    "ing_id": ing_id
                },
                success: function(result) {
                    var cols = result.col;
                    $('#ingredient_tbl tbody').append(cols);
                    $("#ingredient option:selected").remove();
                    $('#ingredient_tbl tbody tr:last #quantity').focus();
                }
            });
        });

        $(document).on('change', '#quantity', function(e) {
            e.preventDefault();
            var el = $(this);
            var quantity = el.val();
            var unit_price_str = el.closest('tr').find('span.uprice').text();

            // Remove commas from unit_price_str
            var unit_price = parseFloat(unit_price_str.replace(/,/g, ''));
            // var unit_price = el.closest('tr').find('span.uprice').text();
            var cost = Number(quantity) * Number(unit_price);
            el.closest('tr').find('span.cost').html(Number(cost).toFixed(2));
            getTotal();
        });

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


        function sendDataToServer() {

            // console.log("sendDataToServer() function called.");
            $('.btn-primary').prop('disabled', true);


            var tableData = [];
            $('#ingredient_tbl tbody tr').each(function(index, row) {


                var rowData = {

                    'name': $(row).find('.iname').text(),
                    'available_qty': $(row).find('.available_qty').val(),
                    'consumption_qty': $(row).find('.consumption_qty').val(),
                    'unit_price': $(row).find('.uprice').text(),
                    'cost': $(row).find('.cost').text()

                };
                tableData.push(rowData);
                // console.log($(row).find('.consumption_qty'));
                // console.log($(row).find('.iname'));
            });



            // Serialize the table data to JSON
            var serializedTableData = JSON.stringify(tableData);

            // alert("Table Data: " + serializedTableData);


            // Append the serialized table data to the form
            $('#table_data_input').val(serializedTableData);

            // Submit the form
            $('#product_form').submit();


        }
        // $(document).ready(function() {
        //     $('#updateButton').click(function() {
        //         console.log("Update button clicked.");
        //         sendDataToServer();
        //     });
        // });
    </script>
@endsection
