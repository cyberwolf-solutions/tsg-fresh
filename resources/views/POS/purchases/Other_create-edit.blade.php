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
                </div>
            </div>
        </div>
    </div>
    @php
        $allProducts = \App\Models\Product::with('variants')->get(); // load variants
    @endphp

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('opurchases.store') }}" id="purchase-form">
        @csrf

        <div class="row mb-3 mt-5">
            <div class="col-md-4">
                <label>Purchase Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label>Supplier</label>
                <select name="supplier" class="form-control" id="supplier" required>
                    <option value="">Select Supplier</option>
                    @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" data-vat="{{ $supplier->vat }}">{{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label>Note (optional)</label>
                <input type="text" name="note" class="form-control">
            </div>
        </div>

        <hr>

        {{-- Product Selection --}}
        <div class="row mb-3">
            {{-- <div class="col-md-2">
                <label>Product</label>
                <select id="product-select" class="form-control">
                    <option value="">-- Select Product --</option>
                    @foreach ($allProducts as $product)
                        <option value="{{ $product->id }}"
                            data-has-variants="{{ $product->variants->count() > 0 ? 'yes' : 'no' }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2" id="variant-select-container" style="display: none;">
                <label>Variant</label>
                <select id="variant-select" class="form-control"></select>
            </div> --}}

            <div class="col-md-2">
                <label>Product</label>
                <select id="product-select" class="form-control">
                    <option value="">-- Select Product --</option>
                    @foreach ($allProducts as $product)
                        <option value="{{ $product->id }}"
                            data-has-variants="{{ $product->variants->count() > 0 ? 'yes' : 'no' }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2" id="variant-select-container" style="display: none;">
                <label>Variant</label>
                <select id="variant-select" class="form-control"></select>
            </div>

            <div class="col-md-1">
                <label>Qty</label>
                <input type="number" id="quantity" class="form-control" min="1" value="1">
            </div>

            <div class="col-md-1">
                <label>Unit</label>
                <select id="unit" class="form-control">
                    <option value="">Select Product </option>
                    @foreach ($unit as $product)
                        <option value="{{ $product->name }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Buying Price</label>
                <input type="number" id="buying-price" class="form-control" min="0" step="0.01">
            </div>

            <div class="col-md-2">
                <label for="mfd">Manufacture Date</label>
                <input type="date" id="mfd" class="form-control">
            </div>

            <div class="col-md-2">
                <label for="exp1">Expiry Date</label>
                <input type="date" id="exp1" class="form-control">
            </div>


            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-primary w-100" id="add-product">Add</button>
            </div>
        </div>

        {{-- Purchase Table --}}
        <table class="table table-bordered" id="purchase-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Buying Price</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>MFD</th>
                    <th>EXP</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        {{-- Totals --}}
        <div class="row">
            <div class="col-md-3 offset-md-6">
                <label>Subtotal</label>
                <input type="text" id="subtotal" name="subtotal" class="form-control" readonly>
            </div>

            <div class="col-md-3">
                <label>Discount</label>
                <input type="number" name="discount" id="discount" class="form-control" value="0">
            </div>

            <div class="col-md-3 offset-md-6">
                <label>VAT (%)</label>
                <input type="text" id="vat" name="vat_percentage" class="form-control" readonly>
            </div>

            <div class="col-md-3">
                <label>Grand Total</label>
                <input type="text" id="grand-total" class="form-control" name="total" readonly>
            </div>
        </div>

        {{-- Hidden JSON Field --}}
        <input type="hidden" name="products" id="products-json">


        <hr>

        <button class="btn btn-success mt-3">Save Purchase</button>
    </form>
@endsection

@section('script')
    <script>
        const allProducts = @json($allProducts);

        let selectedProducts = [];

        function updateTable() {
            const tbody = $('#purchase-table tbody');
            tbody.empty();

            let subtotal = 0;
            selectedProducts.forEach((item, index) => {
                subtotal += item.quantity * item.price;
                tbody.append(`
<tr>
    <td>${item.name}</td>
    <td>${item.variant_name ?? '-'}</td>
    <td>${item.price.toFixed(2)}</td>
    <td>${item.quantity}</td>
    <td>${item.unit}</td>
    <td>${item.mfd || '-'}</td>
    <td>${item.exp || '-'}</td>
    <td>${(item.quantity * item.price).toFixed(2)}</td>
    <td><button class="btn btn-sm btn-danger" onclick="removeItem(${index})">Remove</button></td>
</tr>
`);

            });

            $('#subtotal').val(subtotal.toFixed(2));

            const discount = parseFloat($('#discount').val()) || 0;
            const vatPercent = parseFloat($('#vat').val()) || 0;
            const vatAmount = ((subtotal - discount) * vatPercent) / 100;
            const grandTotal = subtotal - discount + vatAmount;

            $('#grand-total').val(grandTotal.toFixed(2));
            $('#products-json').val(JSON.stringify(selectedProducts));
        }

        function removeItem(index) {
            selectedProducts.splice(index, 1);
            updateTable();
        }

        // $('#product-select').change(function() {
        //     const productId = $(this).val();
        //     const selected = allProducts.find(p => p.id == productId);

        //     if (selected.variants.length > 0) {
        //         $('#variant-select').empty().append('<option value="">-- Select Variant --</option>');
        //         selected.variants.forEach(variant => {
        //             $('#variant-select').append(`<option value="${variant.id}">${variant.name}</option>`);
        //         });
        //         $('#variant-select-container').show();
        //     } else {
        //         $('#variant-select-container').hide();
        //     }
        // });


        $('#product-select').change(function() {
            const productId = $(this).val();
            if (!productId) {
                $('#variant-select-container').hide();
                return;
            }
            $.ajax({
                url: `/get-variants/${productId}`,
                method: 'GET',
                success: function(response) {
                    const variants = response.variants;
                    console.log(variants);
                    if (variants.length > 0) {
                        $('#variant-select').empty().append(
                            '<option value="">-- Select Variant --</option>');
                        variants.forEach(variant => {
                            $('#variant-select').append(
                                `<option value="${variant.id}">${variant.variant_name}</option>`
                            );
                        });
                        $('#variant-select-container').show();
                    } else {
                        $('#variant-select').empty();
                        $('#variant-select-container').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    console.log(xhr.responseText);
                    $('#variant-select').empty();
                    $('#variant-select-container').hide();
                }

            });
        });

        $('#supplier').change(function() {
            const vat = $('option:selected', this).data('vat') || 0;
            $('#vat').val(vat);
            updateTable();
        });

        $('#discount').on('input', updateTable);

        $('#add-product').click(function() {
            const productId = $('#product-select').val();
            const variantId = $('#variant-select').val();
            const quantity = parseInt($('#quantity').val());
            const unit = $('#unit').val();
            const price = parseFloat($('#buying-price').val());
            const mfd = $('#mfd').val();
            const exp = $('#exp1').val();

            if (!productId || quantity < 1 || isNaN(price)) {
                alert("Please enter product, quantity, and price.");
                return;
            }


            // Validate dates
            const today = new Date();
            const mfdDate = new Date(mfd);
            const expDate = new Date(exp);

            if (mfd && mfdDate > today) {
                alert("Manufacture date cannot be in the future.");
                return;
            }

            if (exp && expDate < today) {
                alert("Expiry date cannot be in the past.");
                return;
            }

            const product = allProducts.find(p => p.id == productId);
            let variant = null;

            if (product.variants.length > 0) {
                if (!variantId) {
                    alert("Please select a variant.");
                    return;
                }
                variant = product.variants.find(v => v.id == variantId);
            }

            selectedProducts.push({
                id: product.id,
                name: product.name,
                variant_id: variant ? variant.id : null,
                variant_name: variant ? variant.variant_name : null,
                quantity,
                unit,
                price,
                mfd,
                exp
            });

            updateTable();
            $('#product-select').val('');
            $('#variant-select').empty();
            $('#variant-select-container').hide();
            $('#quantity').val(1);
            $('#unit').val('');
            $('#buying-price').val('');
            $('#mfd').val('');
            $('#exp1').val('');
        });
    </script>
    <script>
        function submitForm() {
            // Update hidden input fields with calculated values
            $('#products-input').val(JSON.stringify(getProducts()));
            $('#subtotal-input').val($('#sub').data('value'));
            $('#discount').val(parseFloat($('#discount-input').val()) || 0);
            $('#vat').val(parseFloat($('#vat-input').val()) || 0);

            // Submit the form
            $('#purchase-form').submit();
        }

        function getProducts() {
            var products = [];
            $('#product-table tbody tr').each(function() {
                var product = {
                    id: $(this).find('td:eq(1)').data('id'),
                    price: parseFloat($(this).find('td:eq(2)').text().replace('{{ $settings->currency }}', '')
                        .trim().replace(/,/g, '')),
                    quantity: parseInt($(this).find('.quantity').val())
                };
                products.push(product);
            });
            return products;
        }
    </script>
    <script>
        $(document).ready(function() {
            var counter = 0;

            // Add product to table
            $('#product-select').change(function() {
                var productId = $(this).val();
                var productName = $(this).find('option:selected').text();
                var productPrice = $(this).find('option:selected').data('price');

                if (productId !== '') {
                    // Check if product already exists in table
                    if ($('#product-table tbody').find('[data-id="' + productId + '"]').length === 0) {
                        counter++;
                        var newRow = '<tr data-id="' + productId + '">' +
                            '<td>' + counter + '</td>' +
                            '<td data-id="' + productId + '">' + productName + '</td>' +
                            '<td>{{ $settings->currency }} ' + numberWithCommas(productPrice.toFixed(2)) +
                            '</td>' +
                            '<td><input type="number" class="form-control quantity" value="1" min="1"></td>' +
                            '<td class="total">{{ $settings->currency }} ' + numberWithCommas(productPrice
                                .toFixed(2)) + '</td>' +
                            '<td class="text-center"><button class="btn btn-light bg-transparent border-0 text-danger delete-row"><i class="ri-delete-bin-2-line"></i></button></td>' +
                            '</tr>';
                        $('#product-table tbody').append(newRow);
                    }
                    recalculateTotal();
                }
            });

            // Delete product row
            $(document).on('click', '.delete-row', function() {
                $(this).closest('tr').remove();
                recalculateTotal();
            });

            // Update total when quantity changes
            $(document).on('change', '.quantity', function() {
                var quantity = $(this).val();
                var price = $(this).closest('tr').find('td:nth-child(3)').text().replace(
                    '{{ $settings->currency }}', '').replace(/,/g, '');
                $(this).closest('tr').find('.total').text('{{ $settings->currency }} ' + numberWithCommas((
                    price *
                    quantity).toFixed(2)));
                recalculateTotal();
            });

            // Recalculate total price
            function recalculateTotal() {
                var total = 0;
                $('#product-table tbody tr').each(function() {
                    total += parseFloat($(this).find('.total').text().replace('{{ $settings->currency }}',
                        '').replace(/,/g, ''));
                });
                $('#sub').text('{{ $settings->currency }} ' + numberWithCommas(total.toFixed(2)));
                $('#total').text('{{ $settings->currency }} ' + numberWithCommas(total.toFixed(2)));

                $('#sub').data('value', total);
                $('#total').data('value', total);

                var subtotal = 0;
                var discount = parseFloat($('#discount-input').val()) || 0;
                var vatPercentage = parseFloat($('#vat-input').val()) || 0;

                // Calculate subtotal
                $('#product-table tbody tr').each(function() {
                    var price = parseFloat($(this).find('.total').text().replace(
                        '{{ $settings->currency }}', '').replace(/,/g, ''));
                    subtotal += price;
                });

                // Apply discount
                subtotal -= discount;

                // Apply VAT
                var vatAmount = (subtotal * vatPercentage) / 100;
                subtotal += vatAmount;

                // Update subtotal, total, and handle errors
                // $('#sub').text('{{ $settings->currency }} ' + numberWithCommas(subtotal.toFixed(2)));
                if (isNaN(subtotal)) {
                    $('#total').text('{{ $settings->currency }} 0.00');
                    // Handle error message
                } else {
                    $('#total').text('{{ $settings->currency }} ' + numberWithCommas(subtotal.toFixed(2)));
                    // Clear error message if previously displayed
                }
            }

            // Function to add commas for thousands separator
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#supplier-select').change(function() {
                let vat = $(this).find('option:selected').data('vat');
                if (!isNaN(vat)) {
                    $('#vat-input').val(vat);
                    $('#vat').val(vat);
                    $('#vat-input').trigger('input'); // To recalculate totals
                }
            });

            // Function to calculate total
            function calculateTotal() {
                var subtotal = 0;
                var discount = parseFloat($('#discount-input').val()) || 0;
                var vatPercentage = parseFloat($('#vat-input').val()) || 0;
                console.log(discount);
                // Calculate subtotal
                $('#product-table tbody tr').each(function() {
                    var price = parseFloat($(this).find('.total').text().replace(
                        '{{ $settings->currency }}', '').replace(/,/g, ''));
                    subtotal += price;
                });

                // Apply discount
                subtotal -= discount;

                // Apply VAT
                var vatAmount = (subtotal * vatPercentage) / 100;
                subtotal += vatAmount;

                // Update subtotal, total, and handle errors
                // $('#sub').text('{{ $settings->currency }} ' + numberWithCommas(subtotal.toFixed(2)));
                if (isNaN(subtotal)) {
                    $('#total').text('{{ $settings->currency }} 0.00');
                    // Handle error message
                } else {
                    $('#total').text('{{ $settings->currency }} ' + numberWithCommas(subtotal.toFixed(2)));
                    // Clear error message if previously displayed
                }
            }

            // Trigger calculateTotal function when discount or VAT input changes
            $('#discount-input, #vat-input').on('input', calculateTotal);

            // Function to add commas for thousands separator
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        });
    </script>
@endsection
