@extends('landing-page.layouts.app')

@section('content')
    <style>
        /* Main Styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: #606060;
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
            margin-top: 50px;
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
            /* Blue background */
            color: #fff;
            /* White text */
            border-color: #007bff;
        }

        .coupon-container {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            border: none;
            /* No border when collapsed */
            padding: 0;
            /* No padding when collapsed */
        }

        .coupon-container.expanded {
            max-height: 200px;
            /* increase to fit content */
            border: 2px dotted #0d6efd;
            padding: 15px;
            /* adds space around span + input */
            border-radius: 8px;
            /* optional for nicer look */
        }



        .coupon-input-group {
            display: flex;
            margin-top: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .coupon-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-right: none;
            border-radius: 8px 0 0 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        .coupon-input:focus {
            border-color: #666;
        }

        .coupon-button {
            padding: 12px 20px;
            background-color: #2265e0;
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .coupon-button:hover {
            background-color: #333;
        }

        .coupon-link {
            cursor: pointer;
            transition: color 0.2s;
        }

        .coupon-link:hover {
            color: #666 !important;
        }
    </style>
    <!-- Hero Banner -->





    <div class="container my-5" style="margin-top: 120px;">
        <!-- Breadcrumb -->
        <div class="col-md-12 d-flex justify-content-center">
            <nav aria-label="breadcrumb" style="margin-top: 110px">
                <ol class="breadcrumb-custom">

                    <li class="breadcrumb-item " style="font-size: 25px;"><a href="{{ route('cart.index') }}"
                            class="text-decoration-none text-dark">
                            SHOPPING CART
                        </a></li>
                    <li class="breadcrumb-item active" style="font-size: 25px;">
                        <a href="{{ route('checkout.index') }}" class="text-decoration-none text-dark">
                            CHECKOUT DETAILS
                        </a>
                    </li>

                    <li class="breadcrumb-item" aria-current="page" style="font-size: 25px;">ORDER COMPLETE</li>
                </ol>
            </nav>
        </div>
        <!-- Info Bar -->


        <!-- Login and Coupon -->
        <div class="text-start mb-1">
            @if (!Auth::guard('customer')->check())
                <p class="small text-secondary mb-1">
                    Returning customer?
                    <a href="#" class="text-dark text-decoration-none"> Click here to login</a>
                </p>
            @endif
            <p class="small text-secondary mb-0">
                Have a coupon?
                <a href="#" class="text-dark text-decoration-none coupon-link" id="couponToggle">Click here to enter
                    your code</a>
            </p>
            <div class="coupon-container mt-4 mb-0" id="couponContainer">
                <span class=" text-secondary">If you have a coupon code, please apply it below.</span>
                <div class="coupon-input-group ">

                    <input type="text" class="coupon-input" placeholder="Enter coupon code">
                    <button class="coupon-button">APPLY COUPON</button>
                </div>
            </div>
        </div>

        <hr class="custom-grey-hr" style="border-color:#ccc; width:58%; opacity:1; margin-top:0;">


        <form action="{{ route('web.checkout.place') }}" method="POST">
            @csrf
            <!-- Checkout Grid -->
            <div class="row mt-0">
                <!-- Billing & Shipping -->
                <div class="col-md-7 mt-2">
                    <h5 class="text-dark fw-semibold" style="font-size: 18px">BILLING & SHIPPING</h5>

                    @if (Auth::guard('customer')->check())
                        <!-- Existing form for authenticated customers -->

                        <input type="hidden" name="web_customer_id" value="{{ $customer->id ?? '' }}">

                        <!-- Name -->
                        <div class="row">
                            <div class="col-md-6 mb-3 text-dark small fw-semibold">
                                <label class="form-label">First name *</label>
                                <input type="text" class="form-control" name="first_name"
                                    value="{{ old('first_name', $customer->billingAddress->first_name ?? ($customer->first_name ?? '')) }}"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3 text-dark small fw-semibold">
                                <label class="form-label">Last name (optional)</label>
                                <input type="text" class="form-control" name="last_name"
                                    value="{{ old('last_name', $customer->billingAddress->last_name ?? ($customer->last_name ?? '')) }}">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Street address *</label>
                            <input type="text" class="form-control mb-2" placeholder="House number and street name"
                                name="address1"
                                value="{{ old('address1', $customer->billingAddress->street_address ?? '') }}" required>
                            <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)"
                                name="address2" value="{{ old('address2', $customer->billingAddress->address2 ?? '') }}">
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Town / City *</label>
                            <input type="text" class="form-control" name="city"
                                value="{{ old('city', $customer->billingAddress->town ?? 'Kandy') }}" required>
                        </div>

                        <!-- Phone & Email -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Phone *</label>
                            <input type="tel" class="form-control" name="phone"
                                value="{{ old('phone', $customer->billingAddress->phone ?? '') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Email address *</label>
                            <input type="email" class="form-control" name="email"
                                value="{{ old('email', $customer->billingAddress->email ?? ($customer->email ?? '')) }}"
                                required>
                        </div>

                        <!-- Additional Info -->
                        <div class="mb-3">
                            <label class="form-label small text-dark fw-semibold">Order notes (optional)</label>
                            <textarea class="form-control" name="notes" placeholder="Special notes for delivery.">{{ old('notes') }}</textarea>
                        </div>
                    @else
                        <!-- Form for guest users (not authenticated) -->

                        @csrf

                        <!-- First & Last Name -->
                        <div class="row">
                            <div class="col-md-6 mb-3 text-dark small fw-semibold">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="col-md-6 mb-3 text-dark small fw-semibold">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Street Address *</label>
                            <input type="text" class="form-control mb-2" name="address1"
                                placeholder="House number and street name" required>
                            <input type="text" class="form-control" name="address2"
                                placeholder="Apartment, suite, unit, etc. (optional)">
                        </div>

                        <!-- City -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Town / City *</label>
                            <input type="text" class="form-control" name="city" value="Kandy" required>
                        </div>

                        <!-- Phone & Email -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Phone *</label>
                            <input type="tel" class="form-control" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Email Address *</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <!-- Create Account -->
                        <div class="mb-3">
                            <label class="form-label text-dark small fw-semibold">Create Account Password *</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <!-- Additional Info -->
                        <div class="mb-3">
                            <label class="form-label small text-dark fw-semibold">Order Notes (optional)</label>
                            <textarea class="form-control" name="notes" placeholder="Special notes for delivery."></textarea>
                        </div>
                    @endif
                </div>

                <!-- Order Summary -->
                <div class="col-md-5">
                    <div class="card border-primary">
                        <div class="card-body">
                            <h5 class="card-title mt-3 mb-2">YOUR ORDER</h5>

                            <!-- Header -->
                            <div class="d-flex justify-content-between mt-2 text-secondary small">
                                <strong>PRODUCT</strong>
                                <strong>SUBTOTAL</strong>
                            </div>
                            <hr style="margin-top:5px; margin-bottom:8px;">

                            <!-- Cart Items -->
                            @foreach ($cart->items as $item)
                                @php
                                    $price = $item->variant ? $item->variant->variant_price : $item->product->price;
                                @endphp
                                <div class="d-flex justify-content-between align-items-center text-secondary small mb-2">
                                    <div class="d-flex align-items-center" style="gap:10px;">
                                        <img src="{{ asset($item->product->image ?? 'build/images/landing/l1.png') }}"
                                            alt="Product Image" style="width:50px; height:50px;" class="img-thumbnail">
                                        <div>
                                            <span>{{ $item->product->name }}</span>
                                            @if ($item->variant)
                                                <span> - {{ $item->variant->variant_name }}</span>
                                            @endif
                                            <br>
                                            <span>Qty: {{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                    <span class="text-dark fw-semibold">රු
                                        {{ number_format($price * $item->quantity, 2) }}</span>
                                </div>
                                <hr>
                            @endforeach

                            <!-- Subtotal -->
                            <div class="d-flex justify-content-between text-secondary small">
                                <span>Subtotal</span>
                                <span id="subtotalField" class="text-dark fw-semibold">රු
                                    {{ number_format($subtotal, 2) }}</span>
                            </div>

                            <!-- Discount -->
                            <div class="d-flex justify-content-between mt-2">
                                <span class="small text-secondary" style="font-size:12px; line-height:1.2;">
                                    5% off for purchase above 12,500.00
                                </span>
                                <span id="discountValue" class="text-dark fw-semibold">රු
                                    {{ number_format($discount, 2) }}</span>
                            </div>

                            <!-- Shipping -->
                            <span class="small text-secondary mt-3 d-block">Shipping</span>
                            <hr style="height:2px; margin-top:0; margin-bottom:0;" class="mb-3">

                            @if ($subtotal >= 10000)
                                <!-- Subtotal above 10,000 -->
                                <div class="form-check" style="margin-left: 10px; margin-right:10px;">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="delivery1"
                                        value="Shipping" checked>
                                    <label class="form-check-label" for="delivery1" style="font-size:12px;">
                                        Free Delivery in Limited Area (above Rs. 10,000 order) (Free)
                                    </label>
                                </div>

                                <div class="form-check" style="margin-left: 10px; margin-right:10px;">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="pickup"
                                        value="Store Pickup">
                                    <label class="form-check-label" for="pickup" style="font-size:12px;">
                                        Store Pickup - #38, Charles Dr, Kollupitiya, Colombo 3
                                    </label>
                                </div>
                            @else
                                <!-- Subtotal below 10,000 -->
                                <div class="form-check" style="margin-left: 10px; margin-right:10px;">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="pickup"
                                        value="Store Pickup" checked>
                                    <label class="form-check-label" for="pickup" style="font-size:12px;">
                                        Store Pickup - #38, Charles Dr, Kollupitiya, Colombo 3
                                    </label>
                                </div>

                                <div class="form-check" style="margin-left: 10px; margin-right:10px;">
                                    <input class="form-check-input" type="radio" name="delivery_method" id="delivery1"
                                        value="Shipping">
                                    <label class="form-check-label" for="delivery1" style="font-size:12px;">
                                        Delivery in Limited Areas: රු{{ number_format($deliveryCharge, 2) }}
                                    </label>
                                </div>
                            @endif



                            <!-- Total -->
                            <div class="d-flex justify-content-between mt-3">
                                <span class="small text-secondary">Total</span>
                                <span id="orderTotal" class="small text-dark fw-semibold">රු
                                    {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="text-end">
                                <small class="text-muted" style="font-size: 12px">(includes VAT)</small>
                            </div>

                            <hr>

                            <!-- Delivery Date -->
                            <div class="mb-3">
                                <label for="deliveryDate" class="form-label small fw-bold">Delivery Date *</label>
                                <input type="text" class="form-control mb-3" style="width: 300px;"
                                    name="delivery_date" placeholder="Choose a date" id="deliveryDate">
                                <span style="font-size: 10px; margin-bottom: 10px;" class="text-secondary">
                                    We will try our best to deliver your order on the specified date.
                                </span>
                            </div>

                            <!-- Payment Methods -->
                            <span class="small text-secondary">Payment</span>
                            <hr style="height:2px; margin-top:0; margin-bottom:0;" class="mb-3">
                            <div class="mb-3">
                                <div class="form-check" style="margin-left: 10px; margin-right:10px;">
                                    <input type="radio" class="form-check-input" name="payment_method" id="payment1"
                                        value="Bank" checked>
                                    <label class="form-check-label" for="payment1" style="font-size:12px;">Direct bank
                                        transfer</label>
                                </div>
                                <div class="form-check mb-3" style="margin-left: 10px; margin-right:10px;">
                                    <input type="radio" class="form-check-input" name="payment_method" id="payment2"
                                        value="COD">
                                    <label class="form-check-label" for="payment2" style="font-size:12px;">Cash on
                                        Delivery -
                                        COD</label>
                                </div>
                                <div class="form-check mb-3" style="margin-left: 10px; margin-right:10px;">
                                    <input type="radio" class="form-check-input" name="payment_method" id="payment3"
                                        value="Card">
                                    <label class="form-check-label" for="payment3" style="font-size:12px;">Online
                                        Payment</label>
                                    <div class="mt-2 ms-4">
                                        <img src="https://www.payhere.lk/downloads/images/payhere_long_banner.png"
                                            alt="PayHere" style="max-width: 100%;">
                                    </div>
                                </div>
                            </div>

                            <!-- Place Order Button -->
                            <button type="submit" class="btn custom-outline-blue w-100" id="check">PLACE
                                ORDER</button>
                        </div>
                    </div>
                </div>
        </form>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    </div>

    <hr>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Latest Products -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h5>Latest</h5>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns">
                            <div class="footer-product-info">
                                <h6>Clean Jumbo Prawns 500g</h6>
                                <p class="price">Rs 2,450.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Squid">
                            <div class="footer-product-info">
                                <h6>Squid</h6>
                                <p class="price">From: Rs 1,525.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Kochi Bites 500g">
                            <div class="footer-product-info">
                                <h6>Kochi Bites 500g</h6>
                                <p class="price">Rs 2,530.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Kochi Bites 240g">
                            <div class="footer-product-info">
                                <h6>Kochi Bites 240g</h6>
                                <p class="price">Rs 1,330.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Best Selling -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h5>Best Selling</h5>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Prawns 1kg">
                            <div class="footer-product-info">
                                <h6>Clean Prawns 1kg</h6>
                                <p class="price">From: Rs 3,400.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Crab Meat">
                            <div class="footer-product-info">
                                <h6>Crab Meat</h6>
                                <p class="price">From: Rs 2,360.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Seer Fish">
                            <div class="footer-product-info">
                                <h6>Seer Fish</h6>
                                <p class="price">From: Rs 750.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Whole Prawns">
                            <div class="footer-product-info">
                                <h6>Whole Prawns</h6>
                                <p class="price">From: Rs 2,065.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Rated -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h5>Top Rated</h5>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Handella (Anchovies) 500g">
                            <div class="footer-product-info">
                                <h6>Handella (Anchovies) 500g</h6>
                                <p class="rating">★★★★★</p>
                                <p class="price">Rs 1,121.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Pak Choi & Mushroom Dumplings">
                            <div class="footer-product-info">
                                <h6>Pak Choi & Mushroom Dumplings [10 Pieces]</h6>
                                <p class="rating">★★★★★</p>
                                <p class="price">Rs 1,500.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Atlantic Cod Steak 500g">
                            <div class="footer-product-info">
                                <h6>Atlantic Cod Steak (500g)</h6>
                                <p class="rating">★★★★★</p>
                                <p class="price">Rs 1,475.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#deliveryDate", {
            dateFormat: "d/m/Y"
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const couponToggle = document.getElementById('couponToggle');
            if (couponToggle) {
                couponToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const container = document.getElementById('couponContainer');
                    if (container) {
                        container.classList.toggle('expanded');
                        this.textContent = container.classList.contains('expanded') ?
                            'Hide coupon field' : 'Click here to enter your code';
                    }
                });
            }
        });
    </script>
    <script>
        const deliveryCharge = {{ $deliveryCharge }};
        const subtotal = {{ $subtotal }};
        let total = subtotal;

        const orderTotalEl = document.getElementById('orderTotal');
        const deliveryRadio = document.getElementById('delivery1');
        const pickupRadio = document.getElementById('pickup');

        function updateTotal() {
            total = subtotal;
            if (subtotal < 10000 && deliveryRadio.checked) {
                total += deliveryCharge;
            }
            orderTotalEl.innerText = 'රු ' + total.toFixed(2);
        }

        deliveryRadio.addEventListener('change', updateTotal);
        pickupRadio.addEventListener('change', updateTotal);

        // Initialize total on page load
        updateTotal();
    </script>

@endsection
