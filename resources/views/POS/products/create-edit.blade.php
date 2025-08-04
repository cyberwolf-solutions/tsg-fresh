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
                <form method="POST" class="ajax-form" id="product_form"
                    action="{{ $is_edit ? route('products.update', $data->id) : route('products.store') }}">
                    @csrf
                    @if ($is_edit)
                        @method('PATCH')
                    @endif
                    <div class="row">
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Type</label>
                            <select name="type" class="form-control js-example-basic-single" id="" required>
                                <option value="">Select...</option>
                                @php
                                    $types = ['KOT', 'BOT'];
                                @endphp
                                @foreach ($types as $item)
                                    <option value="{{ $item }}"
                                        {{ $is_edit && $data->type == $item ? 'selected' : '' }}>
                                        {{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" required />
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Code</label>
                            <input type="text" name="pcode" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" placeholder="" required />
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Barcode symbology</label>
                            <select name="barcode" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Brand</label>
                            <select name="brand" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Category</label>
                            <select name="category" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Unit</label>
                            <select name="punit" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Sale Unit</label>
                            <select name="sunit" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Purchase Unit</label>
                            <select name="purchaseunit" class="form-control js-example-basic-single" id=""
                                required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Cost</label>
                            <input type="text" name="cost" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_usd : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Price</label>
                            <input type="text" name="pprice" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_eu : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Alert Quantity</label>
                            <input type="text" name="qty" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_eu : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product tax</label>
                            <input type="text" name="tax" id="" class="form-control"
                                value="{{ $is_edit ? $data->unit_price_eu : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Tax method</label>
                            <select name="taxmethod" class="form-control js-example-basic-single" id=""
                                required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Tax status</label>
                            <select name="taxmethod" class="form-control js-example-basic-single" id=""
                                required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Tax class</label>
                            <select name="taxmethod" class="form-control js-example-basic-single" id=""
                                required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3 required">

                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    Default checkbox
                                </label>
                            </div>
                        </div>
                    </div>

                    <hr style="border: none; border-top: 1px solid #666; margin: 1rem 0;">


                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Product image</label>

                            <div id="dropZone" onclick="document.getElementById('imageInput').click();"
                                ondragover="event.preventDefault(); this.style.backgroundColor='#e6f7ff'; this.style.borderColor='#4099ff';"
                                ondragleave="this.style.backgroundColor='#f9f9f9'; this.style.borderColor='#ccc';"
                                ondrop="handleDrop(event)"
                                style="border: 2px dashed #ccc; border-radius: 10px; padding: 30px; text-align: center; cursor: pointer; background-color: #f9f9f9;">
                                <p>Drag & drop an image here, or <span
                                        style="color: blue; text-decoration: underline;">click to select</span></p>
                                <input type="file" id="imageInput" name="image" accept="image/*"
                                    onchange="handleFile(this.files[0])" style="display: none;">
                                <img id="previewImage" src="#" alt="Preview"
                                    style="display: none; margin-top: 10px; max-width: 100%; border-radius: 10px;">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="" class="form-label">Product description</label>
                            <textarea name="productDetails" id="editor"
                                style="width:100%; height:300px; border-radius: 8px; border: 1px solid #ccc; padding:10px;">
                            </textarea>

                        </div>

                        <hr style="border: none; border-top: 1px solid #666; margin: 1rem 0;">


                        {{-- variable product --}}
                        <div class="col-md-12 col-12 mb-3 required">
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for="" class="form-label">Product type</label>
                                    <select name="ptype" class="form-control js-example-basic-single" id="ptype"
                                        required>
                                        <option value="">Nothing selected</option>
                                        <option value="simple">Simple product</option>
                                        <option value="grouped">Grouped product</option>
                                        <option value="variable">Variable product</option>
                                    </select>
                                </div>
                            </div>

                            <div id="variant-group" style="display: none;">
                                <div id="variant-container">
                                    <div class="row variant-row">
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <label for="" class="form-label">Type name</label>
                                            <input type="text" name="tname[]" class="form-control"
                                                placeholder="Enter Type Name" required>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <label for="" class="form-label">Type price</label>
                                            <input type="text" name="tprice[]" class="form-control"
                                                placeholder="Enter Type Price" required>
                                        </div>
                                        <div class="col-12 col-md-2 col-lg-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger remove-row">Remove</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <button type="button" class="btn btn-primary" id="add-variant">+ Add
                                            Variant</button>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <hr style="border: none; border-top: 1px solid #666; margin: 1rem 0;">



                        <div class="col-12">
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    This product has different price for different warehouses
                                </label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    This product has batch and expire dates
                                </label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    This product has varient
                                </label>
                            </div>
                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    Add promotional price
                                </label>
                            </div>

                            <div class="form-check mt-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefault">
                                <label class="form-check-label" for="checkDefault">
                                    Limit purchase to 1 item per order
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-light me-2"
                                onclick="window.location='{{ route('products.index') }}'">Cancel</button>
                            {{-- <button class="btn btn-primary"
                                onclick="collectTableData()">{{ $is_edit ? 'Update' : 'Create' }}</button> --}}
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
    <!-- Load CKEditor 5 CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <!-- Initialize -->
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(document).ready(function() {
            // Toggle visibility based on product type
            $('#ptype').on('change', function() {
                if ($(this).val() === 'variable') {
                    $('#variant-group').show();
                    $('#variant-group input').prop('required', true);
                } else {
                    $('#variant-group').hide();
                    $('#variant-group input').prop('required', false);
                }
            });

            // Add new variant row
            $('#add-variant').click(function() {
                const row = `
                <div class="row variant-row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <input type="text" name="tname[]" class="form-control mt-2" placeholder="Enter Type Name" required>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <input type="text" name="tprice[]" class="form-control mt-2" placeholder="Enter Type Price" required>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger mt-2 remove-row">Remove</button>
                    </div>
                </div>`;
                $('#variant-container').append(row);
            });

            // Remove variant row
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.variant-row').remove();
            });
        });
    </script>

    <script>
        function handleDrop(event) {
            event.preventDefault();
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith("image/")) {
                document.getElementById('imageInput').files = event.dataTransfer.files;
                handleFile(file);
            }
            event.currentTarget.style.backgroundColor = '#f9f9f9';
            event.currentTarget.style.borderColor = '#ccc';
        }

        function handleFile(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById("previewImage");
                img.src = e.target.result;
                img.style.display = "block";
            };
            reader.readAsDataURL(file);
        }


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
                    // $("#ingredient option:selected").remove();
                    $('#ingredient_tbl tbody tr:last #quantity').focus();
                }
            });
        });

        $(document).on('change', '#quantity', function(e) {
            e.preventDefault();
            var el = $(this);
            var quantity = el.val();
            // var unit_price = el.closest('tr').find('span.uprice').text();

            var unit_price_str = el.closest('tr').find('span.uprice').text();

            // Remove commas from unit_price_str
            var unit_price = parseFloat(unit_price_str.replace(/,/g, ''));
            // alert(unit_price);
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
            // $('#product_form').submit();


        }
    </script>
@endsection
