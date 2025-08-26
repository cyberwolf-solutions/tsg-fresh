@extends('landing-page.layouts.app')

@section('content')
    <style>
        /* Main Styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: #585858;
        }

        .custom-qty-group {
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }

        .custom-qty-group .custom-qty-btn {
            background-color: #f5f5f5;
            border: none;
            color: #000;
            padding: 2px 8px;
            font-size: 14px;
        }

        .custom-qty-group .custom-qty-btn:hover {
            background-color: #dcdcdc;
        }

        .qty-input {
            border: none;
            width: 30px;
            padding: 2px;
            font-size: 14px;
        }

        .qty-input:focus {
            box-shadow: none;
            outline: none;
        }


        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://tsg-fresh.com/wp-content/uploads/2023/06/Untitled-1-1.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .hero-banner h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .breadcrumb-custom {
            display: flex;
            flex-wrap: wrap;
            padding: 0;
            margin-bottom: 30px;
            list-style: none;
            background-color: transparent;
            border-radius: 0;
            font-family: 'Poppins', sans-serif;
        }

        .breadcrumb-custom .breadcrumb-item {
            position: relative;
            margin-right: 30px;
            color: #777;
            font-weight: 500;
            font-size: 16px;
        }

        /* Remove the slash and only keep ">" */
        .breadcrumb-custom .breadcrumb-item:not(:last-child)::after {
            content: ">";
            position: absolute;
            right: -20px;
            /* Adjust spacing */
            color: #777;
        }

        /* Link style */
        .breadcrumb-custom .breadcrumb-item a {
            color: #777;
            text-decoration: none;
            transition: color 0.3s ease, font-weight 0.3s ease;
        }

        /* Active style */
        .breadcrumb-custom .breadcrumb-item.active {
            color: #000;
            font-weight: 700;
        }

        /* Hover effect for all items */
        .breadcrumb-custom .breadcrumb-item:hover {
            color: black;
            ;
            font-weight: 700;
            /* Same as active */
            cursor: pointer;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: none;
        }

        /* Product Grid */
        .product-card {
            border: none;
            border-radius: 0;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            position: relative;
            background: #fff;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-card .card-img-top {
            border-radius: 0;
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .product-card .card-body {
            padding: 15px;
            text-align: center;
        }

        .product-card .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .product-card .price {
            color: #d9232d;
            font-weight: 600;
            margin-bottom: 0;
        }

        .out-of-stock {
            color: #d9232d;
            font-weight: 600;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 0;
        }

        /* Sidebar */
        .sidebar-widget {
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .sidebar-widget h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .sidebar-widget ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-widget ul li {
            margin-bottom: 10px;
        }

        .sidebar-widget ul li a {
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            padding: 5px 0;
        }

        .sidebar-widget ul li a:hover {
            color: #d9232d;
            padding-left: 5px;
        }

        /* Price Filter */
        .price-slider {
            width: 100%;
            -webkit-appearance: none;
            height: 5px;
            background: #ddd;
            outline: none;
            margin-top: 15px;
        }

        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            background: #d9232d;
            cursor: pointer;
            border-radius: 50%;
        }

        .price-range {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .btn-filter {
            background-color: #333;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background-color: #d9232d;
        }

        /* Sorting */
        .sorting-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .sorting-options .form-select {
            width: auto;
            border-radius: 0;
            border: 1px solid #ddd;
            padding: 8px 15px;
            font-size: 14px;
        }

        /* Footer */
        .footer {
            background-color: #ffffff;
            padding: 60px 0 30px;
            margin-top: 10px;
        }

        .footer-widget {
            margin-bottom: 30px;
        }

        .footer-widget h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .footer-product {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .footer-product img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin-right: 15px;
        }

        .footer-product-info h6 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
            line-height: 1.3;
        }

        .footer-product-info .price {
            color: #d9232d;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 0;
        }

        .footer-product-info .rating {
            color: #ffc107;
            font-size: 12px;
            margin: 3px 0;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-banner h1 {
                font-size: 36px;
            }
        }

        @media (max-width: 767px) {
            .hero-banner {
                padding: 60px 0;
            }

            .hero-banner h1 {
                font-size: 28px;
            }

            .sorting-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .sorting-options .form-select {
                margin-top: 10px;
                width: 100%;
            }
        }

        .centered-wrapper {
            margin: 0 auto;
            padding-left: 15px;
            padding-right: 15px;
            max-width: 100%;
        }

        @media (min-width: 992px) {
            .centered-wrapper {
                max-width: calc(100% - 400px);
                /* 200px left & right */
                padding-left: 0;
                padding-right: 0;
            }
        }

        .nav-tabs .nav-link {
            color: #333;
            border: none;
            position: relative;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #007bff;
            transition: width 0.3s ease-in-out;
        }



        .custom-outline-blue {
            background-color: #0d6efd !important;
            /* Bootstrap primary blue */
            border-color: #0d6efd !important;
            color: #fff !important;
        }


        .custom-outline-blue:hover {
            background-color: #007bff;
            /* Blue background on hover */

            /* White text on hover */
            border-color: #007bff;
        }


        /* Rest of your existing styles... */
        /* Main Styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: #585858;
        }

        .custom-qty-group {
            border: 1px solid #ccc;
            border-radius: 4px;
            overflow: hidden;
        }

        .custom-qty-group .custom-qty-btn {
            background-color: #f5f5f5;
            border: none;
            color: #000;
            padding: 2px 8px;
            font-size: 14px;
        }

        .custom-qty-group .custom-qty-btn:hover {
            background-color: #dcdcdc;
        }

        .qty-input {
            border: none;
            width: 30px;
            padding: 2px;
            font-size: 14px;
        }

        .qty-input:focus {
            box-shadow: none;
            outline: none;
        }

        .address-form {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .toast-container {
            z-index: 9999 !important;
        }

        .toast {
            min-width: 300px;
        }
    </style>
    <!-- Hero Banner -->

    <div class="container my-5" style="margin-top: 120px;">

        <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11000">
            <!-- Toast Template -->
            <div id="liveToast" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMessage">
                        ⚠️ This is a sample toast message.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>


        <div class="col-md-12 d-flex justify-content-center">
            <nav aria-label="breadcrumb" style="margin-top: 110px">
                <ol class="breadcrumb-custom">
                    <li class="breadcrumb-item active" style="font-size: 25px;">SHOPPING CART</li>
                    <li class="breadcrumb-item" style="font-size: 25px;">
                        <a href="{{ route('checkout.index') }}" class="text-decoration-none text-dark">
                            CHECKOUT DETAILS
                        </a>
                    </li>

                    <li class="breadcrumb-item" aria-current="page" style="font-size: 25px;">ORDER COMPLETE</li>
                </ol>
            </nav>
        </div>



        <div class="row">
            <!-- Cart Table -->
            <div class="col-md-7">
                <div class="card mb-4" style="border: none">
                    <div class="card-body">

                        <table class="table align-middle">
                            <thead>
                                <tr style="color: #666; margine-bottom:10px">
                                    <th style="color: #666;font-style:normal">Product</th>
                                    <th style="color: #666">Price</th>
                                    <th style="color: #666">Quantity</th>
                                    <th style="color: #666">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="mt-4">
                                <tr>
                                    <!-- Product Image and Name -->
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <span class="me-2"><i class="fas fa-times-circle text-danger"></i></span>
                                            <img src="#" alt="Product Image" class="img-thumbnail me-2"
                                                style="width: 80px; height: 80px;">
                                            <span class="text-dark small"> </span>
                                        </div>
                                    </td>

                                    <!-- Price -->
                                    <td class="align-middle text-dark fw-semibold">

                                    </td>

                                    <!-- Quantity Controls -->
                                    <td class="align-middle">
                                        <div class="input-group input-group-sm custom-qty-group" style="width: 90px;">
                                            <button class="btn custom-qty-btn">−</button>
                                            <input type="text" class="form-control text-center qty-input" value="1">
                                            <button class="btn custom-qty-btn">+</button>
                                        </div>

                                    </td>

                                    <!-- Total -->
                                    <td class="align-middle text-dark fw-semibold">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        <a href="#" class="btn custom-outline-blue text-primary fw-bold" style="border-width: 2px">←
                            CONTINUE
                            SHOPPING</a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-md-5">
                <div class="card border-start border-1"
                    style="border-color: #ccc; border-top: none; border-right: none; border-bottom: none;border-radius:0px">
                    <div class="card-body">
                        <label for="deliveryDate" class="form-label small fw-bold">Delivery Date *</label>
                        <input type="text" class="form-control mb-3" style="width: 300px;" id="deliveryDate"
                            placeholder="Choose a date">

                        <span style="font-size: 10px; margin-bottom: 10px; " class="text-secondary">
                            We will try our best to deliver your order on the specified date.
                        </span>

                        <h6 class="text-secondary fw-semibold mb-1 mt-4">CART TOTALS</h6>
                        <hr style="height:2px; margin-top:0; margin-bottom:0;" class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span class="small text-secondary">Subtotal</span>
                            <span class="cart-subtotal">රු3,725.00</span>
                        </div>

                        <hr style="margin-top:0; margin-left:10px; margin-right:10px; border-top:1px solid #ccc;">


                        <div class="d-flex justify-content-between" style="margin: 0 10px;">
                            <span class="small text-secondary" style="font-size:12px; line-height:1.2;">
                                5% off for <br> purchase above 12,500.00
                            </span>
                            <span id="discountValue">රු0.00</span>
                        </div>

                        <hr style="margin: 0 10px; border-top:1px solid #ccc;" class="mb-3">

                        <span class="small text-secondary">Shipping</span>
                        <hr style="height:2px; margin-top:0; margin-bottom:0;" class="mb-3">
                        <div id="shippingOptions" style="margin-left: 10px; margin-right:10px;">
                            <!-- Shipping options will be dynamically inserted here -->
                        </div>



                        <span class="text-secondary" style="margin-left: 10px; margin-right:10px; font-size: 12px;">
                            Shipping to
                            @if ($billingAddress)
                                {{ $billingAddress->street_address }},
                                {{ $billingAddress->town }},
                                {{ $billingAddress->customer->city ?? '' }} <!-- if you have city column in customer -->
                            @else
                                No billing address set.
                            @endif
                        </span>


                        {{-- <span class="text-secondary change-address"
                            style="margin-left: 10px; margin-right: 10px; font-size: 12px; cursor: pointer;">Change
                            Address</span> --}}

                        <div class="address-form"
                            style="display: none; margin-top: 10px; height: 0; overflow: hidden; transition: height 0.3s ease-in-out;">
                            <div class="form-group">
                                <label style="font-size:12px;" class="fw-bold">Country/region</label>
                                <select class="form-control" style="font-size:14px;">
                                    <option>Sri Lanka</option>
                                </select>
                            </div>
                            <div class="form-group mt-2">
                                <label style="font-size:12px;" class="fw-bold">City (optional)</label>
                                <input type="text" class="form-control" value="Kandy" style="font-size:14px;">
                            </div>
                            <div class="form-group mt-2">
                                <label style="font-size:12px;" class="fw-bold">Postcode/ZIP (optional)</label>
                                <input type="text" class="form-control" style="font-size:14px;">
                            </div>
                            <button class="btn btn-primary w-100 mt-3"
                                style="background-color: #007bff; transition: all 0.3s ease;">UPDATE</button>
                        </div>
                        <div class="mt-3 fw-bold">
                            <div class="d-flex justify-content-between">
                                <span class="small text-secondary">Total</span>
                                <span id="orderTotal" class="small">රු4,475.00</span>
                            </div>
                            <div class="text-end">
                                <small class="text-muted" style="font-size: 12px">(includes රු568.22 VAT 18%)</small>
                            </div>
                        </div>

                        <hr>
                        <button class="btn btn-primary custom-outline-blue w-100 mt-3"
                            onclick="window.location='{{ route('checkout.index') }}'">
                            PROCEED TO CHECKOUT
                        </button>


                        <!-- Coupon -->
                        {{-- <div class="mt-3">
                            <label class="form-label text-secondary small fw-bold">Coupon</label>
                            <hr style="height:2px; margin-top:0; margin-bottom:0;" class="mb-3">
                            <input type="text" class="form-control text-secondary small" placeholder="Coupon code">
                            <button class="btn w-100 mt-2"
                                style="background-color: transparent; color: gray; border: 1px solid #6c757d;"
                                onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='white';"
                                onmouseout="this.style.backgroundColor='transparent'; this.style.color='gray';">
                                Apply coupon
                            </button>



                        </div> --}}


                    </div>
                </div>
            </div>
        </div>


    </div>
    <hr>
    <!-- Footer -->
    @include('Landing-Page.partials.products')


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the toast
            var toastEl = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 3000
            });

            // Store the toast instance for global access
            window.appToast = toast;

            // Initialize cart items and shipping options
            fetch("{{ route('cart.sidebar1') }}")
                .then(res => res.text())
                .then(html => {
                    document.querySelector('tbody').innerHTML = html;
                    updateShippingOptions(); // Initialize shipping options
                    updateOrderSummary(); // Update summary after loading cart
                });

            // Handle address form toggle
            document.querySelector('.change-address').addEventListener('click', function() {
                const form = document.querySelector('.address-form');
                if (form.style.height === '0px' || form.style.display === 'none') {
                    form.style.display = 'block';
                    setTimeout(() => {
                        form.style.height = form.scrollHeight + 'px';
                    }, 0);
                } else {
                    form.style.height = '0';
                    setTimeout(() => {
                        form.style.display = 'none';
                    }, 300);
                }
            });
        });

        function showToast(message, type = "warning") {
            let toastEl = document.getElementById("liveToast");
            let toastMessage = document.getElementById("toastMessage");

            toastMessage.innerHTML = message;
            toastEl.classList.remove("text-bg-success", "text-bg-danger", "text-bg-warning");
            if (type === "success") toastEl.classList.add("text-bg-success");
            else if (type === "error") toastEl.classList.add("text-bg-danger");
            else toastEl.classList.add("text-bg-warning");

            if (window.appToast) {
                window.appToast.show();
            } else {
                let toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();
            }
        }

        const deliveryCharge = {{ $deliveryCharge }};

        function updateQuantity(itemId, change = 0, manualValue = null) {
            let row = document.querySelector(`.cart-item[data-id='${itemId}']`);
            if (!row) return;

            let input = row.querySelector('.qty-input');
            let stock = parseInt(row.dataset.stock) || 0;
            let currentQty = parseInt(input.value) || 0;

            let newQty = manualValue !== null ? parseInt(manualValue) : currentQty + change;
            if (newQty < 1) newQty = 1;
            if (newQty > stock) {
                showToast(`⚠️ Only ${stock} items available in stock`, 'error');
                newQty = stock;
            }
            input.value = newQty;

            let price = parseFloat(row.querySelector('td:nth-child(2)').innerText.replace(/[^0-9.]/g, '')) || 0;
            let rowSubtotal = price * newQty;
            row.querySelector('.subtotal').innerText = 'රු ' + rowSubtotal.toFixed(2);

            updateOrderSummary();

            fetch(`/cart/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        quantity: newQty
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        showToast(data.message || 'Failed to update cart', 'error');
                        input.value = currentQty;
                        updateOrderSummary();
                    }
                })
                .catch(err => {
                    console.error(err);
                    input.value = currentQty;
                    updateOrderSummary();
                });
        }

        function updateOrderSummary() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(row => {
                let price = parseFloat(row.querySelector('td:nth-child(2)').innerText.replace(/[^0-9.]/g, '')) || 0;
                let qty = parseInt(row.querySelector('.qty-input').value) || 0;
                subtotal += price * qty;
            });

            // Discount: 5% off for orders above 12500
            let discount = subtotal > 12500 ? subtotal * 0.05 : 0;

            // Shipping cost: Depends on selected delivery option
            let shippingCost = 0;
            const deliveryRadio = document.querySelector('input[name="deliveryOption"]:checked');
            if (deliveryRadio && deliveryRadio.id === 'delivery1' && subtotal < 10000) {
                shippingCost = deliveryCharge;
            }

            // Calculate total
            let total = subtotal - discount + shippingCost;

            // Update summary in DOM
            document.querySelector('.cart-subtotal').innerText = 'රු' + subtotal.toFixed(2);
            document.getElementById('discountValue').innerText = 'රු' + discount.toFixed(2);
            document.getElementById('orderTotal').innerText = 'රු' + total.toFixed(2);

            // Update VAT (18% on total)
            let vat = total * 0.18;
            document.querySelector('.text-end .text-muted').innerText = `(includes රු${vat.toFixed(2)} VAT 18%)`;
        }

        function updateShippingOptions() {
            let subtotalText = document.querySelector('.cart-subtotal').innerText;
            let subtotal = parseFloat(subtotalText.replace(/[^\d.]/g, '')) || 0;
            let shippingContainer = document.getElementById('shippingOptions');
            shippingContainer.innerHTML = '';

            let storePickupOption = `
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio" name="deliveryOption" id="delivery2" checked>
                <label class="form-check-label" for="delivery2" style="font-size:12px;">
                    Store Pickup - #38, Charles Dr, Kollupitiya, Colombo 3
                </label>
            </div>
        `;

            let shippingOption = '';
            if (subtotal >= 10000) {
                shippingOption = `
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="deliveryOption" id="delivery1">
                    <label class="form-check-label" for="delivery1" style="font-size:12px;">
                        Free Delivery in Limited Area (above Rs. 10000 order) (Free)
                    </label>
                </div>
            `;
            } else {
                shippingOption = `
                <div class="form-check mb-3">
                    <input class="form-check-input" type="radio" name="deliveryOption" id="delivery1">
                    <label class="form-check-label" for="delivery1" style="font-size:12px;">
                        Delivery in Limited Areas: රු${deliveryCharge.toFixed(2)}
                    </label>
                </div>
            `;
            }

            shippingContainer.innerHTML = shippingOption + storePickupOption;

            // Add event listeners to delivery options
            document.querySelectorAll('input[name="deliveryOption"]').forEach(radio => {
                radio.addEventListener('change', updateOrderSummary);
            });
        }

        flatpickr("#deliveryDate", {
            dateFormat: "d/m/Y"
        });
    </script>
@endsection
