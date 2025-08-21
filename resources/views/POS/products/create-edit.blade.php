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
                        {{-- <div class="col-md-4 mb-3 required">
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
                        </div> --}}

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" name="name" id="" class="form-control"
                                value="{{ $is_edit ? $data->name : '' }}" required />
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Code</label>
                            <input type="text" name="pcode" id="" class="form-control"
                                value="{{ $is_edit ? $data->product_code : '' }}" placeholder="" required />
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
                                @foreach ($ingredients as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->brand_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Category</label>
                            <select name="category" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-md-4 mb-3 required">
                            <label class="form-label">Categories</label>
                            <div class="dropdown">
                                <button class="form-control text-start dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false" id="categoryDropdown">
                                    Select Categories
                                </button>
                                <ul class="dropdown-menu" style="width: 100%; max-height: 300px; overflow-y: auto;">
                                    @foreach ($categories as $category)
                                        <li class="px-3">
                                            <div class="form-check">
                                                <input class="form-check-input category-checkbox" type="checkbox"
                                                    name="categories[]" value="{{ $category->id }}"
                                                    id="cat_{{ $category->id }}"
                                                    {{ isset($data) && in_array($category->id, $data->category_ids ?? []) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="cat_{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Unit</label>
                            <select name="punit" class="form-control js-example-basic-single" id="" required>
                                <option value="">Nothing selected</option>
                                @foreach ($unit as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $is_edit ?? $data->category_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- <div class="col-md-4 mb-3 required">
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
                        </div> --}}



                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Cost</label>
                            <input type="text" name="cost" id="" class="form-control"
                                value="{{ $is_edit ? $data->cost : '' }}" placeholder="Enter Unit Price" required />
                        </div>
                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Product Price</label>
                            <input type="text" name="pprice" id="" class="form-control"
                                value="{{ $is_edit ? $data->product_price : '' }}" placeholder="Enter Unit Price"
                                required />
                        </div>

                        <div class="col-md-4 mb-3 required">
                            <label for="" class="form-label">Alert Quantity</label>
                            <input type="text" name="qty" id="" class="form-control"
                                value="{{ $is_edit ? $data->qty : '' }}" placeholder="Enter Unit Price" required />
                        </div>





                    </div>
                    <hr class="mt-5 mb-5" style="border: none; border-top: 1px solid #666; margin: 1rem 0;">

                    <div class="row" style="display: none;">
                        <input type="text" name="tax" class="form-control"
                            value="{{ $is_edit ? $data->tax : 0 }}" placeholder="Enter Unit Price" required />


                        <!-- Tax Method -->
                        <div class="col-md-4 mb-3 ">
                            <label for="" class="form-label">Tax Method</label>
                            <select name="taxmethod" class="form-control js-example-basic-single" required>
                                <option value="exclusive">Nothing selected</option>
                                <option value="exclusive"
                                    {{ $is_edit && $data->tax_method === 'exclusive' ? 'selected' : '' }}>Exclusive
                                </option>
                                <option value="inclusive"
                                    {{ $is_edit && $data->tax_method === 'inclusive' ? 'selected' : '' }}>Inclusive
                                </option>
                            </select>
                        </div>

                        <!-- Tax Status -->
                        <div class="col-md-4 mb-3 ">
                            <label for="" class="form-label">Tax Status</label>
                            <select name="taxstatus" class="form-control js-example-basic-single" required>
                                <option value="taxable">Nothing selected</option>
                                <option value="taxable"
                                    {{ $is_edit && $data->tax_status === 'taxable' ? 'selected' : '' }}>Taxable</option>
                                <option value="non-taxable"
                                    {{ $is_edit && $data->tax_status === 'non-taxable' ? 'selected' : '' }}>Non-Taxable
                                </option>
                            </select>
                        </div>

                        <!-- Tax Class -->
                        <div class="col-md-4 mb-3 ">
                            <label for="" class="form-label">Tax Class</label>
                            <select name="taxclass" class="form-control js-example-basic-single" required>
                                <option value="standard">Nothing selected</option>
                                <option value="standard"
                                    {{ $is_edit && $data->tax_class === 'standard' ? 'selected' : '' }}>Standard</option>
                                <option value="reduced"
                                    {{ $is_edit && $data->tax_class === 'reduced' ? 'selected' : '' }}>Reduced</option>
                                <option value="zero" {{ $is_edit && $data->tax_class === 'zero' ? 'selected' : '' }}>
                                    Zero</option>
                            </select>
                        </div>
                    </div>
                    <hr class="mt-5 mb-5" style="border: none; border-top: 1px solid #666; margin: 1rem 0;">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="finalPrice" class="form-label">Final Price</label>
                            <input type="text" id="finalPrice" class="form-control" readonly>
                        </div>
                    </div>

                    <hr class="mt-5 mb-5" class="mt-5 mb-5"
                        style="border: none; border-top: 1px solid #666; margin: 1rem 0;">


                    {{-- image --}}
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
                                style="width:100%; height:300px; border-radius: 8px; border: 1px solid #ccc; padding:10px;">{{ $is_edit ? $data->description : '' }}</textarea>
                        </div>


                        <hr class="mt-5 mb-5" style="border: none; border-top: 1px solid #666; margin: 1rem 0;">


                        {{-- variable product --}}
                        <div class="col-md-12 col-12 mb-3 required">
                            <div class="row">
                                <div class="col-12 col-md-3 col-lg-3">
                                    <label for="" class="form-label">Product type</label>
                                    <select name="ptype" class="form-control js-example-basic-single" id="ptype"
                                        required>
                                        <option value="">Nothing selected</option>
                                        <option value="simple"
                                            {{ isset($data) && $data->product_type === 'simple' ? 'selected' : '' }}>Simple
                                            product</option>
                                        <option value="grouped"
                                            {{ isset($data) && $data->product_type === 'grouped' ? 'selected' : '' }}>
                                            Grouped product</option>
                                        <option value="variable"
                                            {{ isset($data) && $data->product_type === 'variable' ? 'selected' : '' }}>
                                            Variable product</option>
                                    </select>

                                </div>
                            </div>

                            <div id="variant-group" style="display: none;">
                                <div id="variant-container">
                                    @if (isset($pvdata) && $pvdata->product_type === 'variable' && $pvdata->variants)
                                        @foreach ($pvdata->variants as $index => $variant)
                                            <div class="row variant-row">
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <label class="form-label">Type name</label>
                                                    <input type="text" name="tname[]"
                                                        value="{{ $variant->variant_name }}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <label class="form-label">Type price</label>
                                                    <input type="text" name="tprice[]"
                                                        value="{{ $variant->variant_price }}" class="form-control"
                                                        required>
                                                </div>
                                                <div class="col-12 col-md-3 col-lg-3">
                                                    <label class="form-label">Final price</label>
                                                    <input type="text" name="tfprice[]"
                                                        value="{{ $variant->final_price }}" class="form-control" required
                                                        readonly>
                                                </div>
                                                <div class="col-12 col-md-2 col-lg-2 d-flex align-items-end">
                                                    <button type="button"
                                                        class="btn btn-danger remove-row">Remove</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        {{-- default blank row if not editing --}}
                                        <div class="row variant-row">
                                            <div class="col-12 col-md-3 col-lg-3">
                                                <label class="form-label">Type name</label>
                                                <input type="text" name="tname[]" class="form-control"
                                                    placeholder="Enter Type Name" required>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3">
                                                <label class="form-label">Type price</label>
                                                <input type="text" name="tprice[]" class="form-control"
                                                    placeholder="Enter Type Price" required>
                                            </div>
                                            <div class="col-12 col-md-3 col-lg-3">
                                                <label class="form-label">Final price</label>
                                                <input type="text" name="tfprice[]" class="form-control"
                                                    placeholder="Auto-calculated" required disabled>
                                            </div>
                                            <div class="col-12 col-md-2 col-lg-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12 mt-2">
                                        <button type="button" class="btn btn-primary" id="add-variant">+ Add
                                            Variant</button>
                                    </div>
                                </div>
                            </div>


                        </div>

                        <hr class="mt-5 mb-5" style="border: none; border-top: 1px solid #666; margin: 1rem 0;">



                        <div class="col-12">
                            <div class="col-md-4 mb-3 required">

                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="status" value="private"
                                        id="checkDefault">
                                    <label class="form-check-label" for="checkDefault">
                                        Make product private
                                    </label>
                                </div>

                            </div>
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
            function toggleVariantSection() {
                if ($('#ptype').val() === 'variable') {
                    $('#variant-group').show();
                } else {
                    $('#variant-group').hide();
                }
            }

            // On load
            toggleVariantSection();

            // On change
            $('#ptype').on('change', function() {
                toggleVariantSection();
            });
        });
    </script>

    <script>
        function calculateFinalPrice() {
            const price = parseFloat(document.querySelector('[name="pprice"]').value) || 0;
            const tax = parseFloat(document.querySelector('[name="tax"]').value) || 0;
            const taxStatus = document.querySelector('[name="taxstatus"]').value;
            const taxMethod = document.querySelector('[name="taxmethod"]').value;

            let finalPrice = price;

            if (taxStatus === 'taxable') {
                if (taxMethod === 'exclusive') {
                    finalPrice = price + (price * tax / 100);
                } else if (taxMethod === 'inclusive') {
                    finalPrice = price; // already includes tax
                }
            } else if (taxStatus === 'non-taxable') {
                finalPrice = price;
            }

            document.getElementById('finalPrice').value = finalPrice.toFixed(2);
        }

        // ✅ For variants
        function calculateVariantFinalPrices() {
            const tax = parseFloat(document.querySelector('[name="tax"]').value) || 0;
            const taxStatus = document.querySelector('[name="taxstatus"]').value;
            const taxMethod = document.querySelector('[name="taxmethod"]').value;

            document.querySelectorAll('.variant-row').forEach(function(row) {
                const priceInput = row.querySelector('[name="tprice[]"]');
                const finalInput = row.querySelector('[name="tfprice[]"]');

                if (!priceInput || !finalInput) return;

                const price = parseFloat(priceInput.value) || 0;
                let finalPrice = price;

                if (taxStatus === 'taxable') {
                    if (taxMethod === 'exclusive') {
                        finalPrice = price + (price * tax / 100);
                    } else if (taxMethod === 'inclusive') {
                        finalPrice = price; // already includes tax
                    }
                } else {
                    finalPrice = price;
                }

                finalInput.value = finalPrice.toFixed(2);
            });
        }

        // Attach event listeners
        document.querySelector('[name="pprice"]').addEventListener('input', calculateFinalPrice);
        document.querySelector('[name="tax"]').addEventListener('input', calculateFinalPrice);
        document.querySelector('[name="taxstatus"]').addEventListener('change', calculateFinalPrice);
        document.querySelector('[name="taxmethod"]').addEventListener('change', calculateFinalPrice);
        // Attach events to variant price inputs dynamically
        document.addEventListener('input', function(e) {
            if (e.target.matches('[name="tprice[]"]')) {
                calculateVariantFinalPrices();
            }
        });

        // Initial calc
        document.addEventListener('DOMContentLoaded', () => {
            calculateFinalPrice();
            calculateVariantFinalPrices();
        });
        // // Initial calculation
        // document.addEventListener('DOMContentLoaded', calculateFinalPrice);
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
                    <div class="col-12 col-md-3 col-lg-3">
                        <input type="text" name="tname[]" class="form-control mt-2" placeholder="Enter Type Name" required>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <input type="text" name="tprice[]" class="form-control mt-2" placeholder="Enter Type Price" required>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                      <input type="text" name="tfprice[]"
                                                       class="form-control" required
                                                        disabled>
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
