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

        .order-complete {
            font-family: 'Poppins', sans-serif;
            margin-top: 120px;
            margin-bottom: 50px;
        }

        .order-box {
            background: #fff;
            border: 1px solid #eee;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .order-summary {
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 20px;
            margin-top: 20px;
        }

        .order-summary ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-summary ul li {
            margin-bottom: 10px;
            font-size: 14px;
        }

        .bank-details {
            margin-top: 30px;
        }

        .bank-details h4 {
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .table-order {
            margin-top: 20px;
        }

        .table-order th {
            background: #f1f1f1;
            font-weight: 600;
            font-size: 14px;
        }

        .table-order td,
        .table-order th {
            padding: 10px 15px;
            border: 1px solid #eee;
        }

        .billing-address {
            margin-top: 30px;
        }

        .billing-address h4 {
            font-size: 18px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .btn-invoice {
            margin-top: 15px;
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 10px 18px;
            border-radius: 5px;
            transition: 0.3s;
        }

        .btn-invoice:hover {
            background: #0056b3;
        }
    </style>
    <!-- Hero Banner -->






    <div class="container order-complete">
        <!-- Breadcrumb -->
        <div class="col-md-12 d-flex justify-content-center">
            <nav aria-label="breadcrumb" style="margin-top: 50px">
                <ol class="breadcrumb-custom">
                    <li class="breadcrumb-item" style="font-size: 20px;">
                        <a href="{{ route('cart.index') }}" class="text-decoration-none text-dark">SHOPPING CART</a>
                    </li>
                    <li class="breadcrumb-item" style="font-size: 20px;">
                        <a href="{{ route('checkout.index') }}" class="text-decoration-none text-dark">CHECKOUT DETAILS</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page" style="font-size: 20px;">ORDER COMPLETE</li>
                </ol>
            </nav>
        </div>

        <!-- Order Complete Section -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="order-box">
                    @if ($order->payment_method === 'Bank')
                        <h4>Our bank details</h4>
                        @if ($bankDetails)
                            <p><strong>Taprobane Seafoods Group Investments :</strong></p>
                            <p>
                                <strong>Bank:</strong> {{ $bankDetails->bank_name }} <br>
                                <strong>Account number:</strong> {{ $bankDetails->account_number }} <br>
                                <strong>Branch:</strong> {{ $bankDetails->branch }} - {{ $bankDetails->city }}
                            </p>
                        @endif
                    @endif


                    <h4 class="mt-4">Order details</h4>
                    <table class="table-order w-100">
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name }} × {{ $item->quantity }}</td>
                                    <td>₨{{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><strong>Subtotal:</strong></td>
                                <td>₨{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Delivery:</strong></td>
                                <td>{{ $order->delivery_method }}</td>
                            </tr>
                            <tr>
                                <td><strong>Payment method:</strong></td>
                                <td>{{ $order->payment_method }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total:</strong></td>
                                <td><strong>₨{{ number_format($order->total, 2) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- <a href="#" class="btn btn-invoice">TAX INVOICE</a> --}}
                    <a href="{{ route('invoice.print', $order->id) }}" class="btn btn-invoice" target="_blank">
                        INVOICE
                    </a>



                    <p class="mt-3"><strong>Delivery Date:</strong>
                        {{ \Carbon\Carbon::parse($order->delivery_date)->format('d F, Y') }}
                    </p>

                    <!-- Billing -->
                    <div class="billing-address">
                        <h4>Billing address</h4>
                        @if ($customer && $customer->billingAddress)
                            <p>
                                {{ $customer->first_name }} {{ $customer->last_name }} <br>
                                {{ $customer->billingAddress->street_address }} <br>
                                {{ $customer->billingAddress->town }} <br>
                                {{ $customer->billingAddress->phone }} <br>
                                {{ $customer->billingAddress->email }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <p class="text-success fw-bold">Thank you. Your order has been received.</p>
                    <ul>
                        <li><strong>Order number:</strong> {{ $order->id }}</li>
                        <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</li>
                        <li><strong>Email:</strong> {{ $customer->email }}</li>
                        <li><strong>Total:</strong> ₨{{ number_format($order->total, 2) }}</li>
                        <li><strong>Payment method:</strong> {{ $order->payment_method }}</li>
                    </ul>
                </div>
            </div>
        </div>

        @include('Landing-Page.partials.products')

        <script>
            document.getElementById('taxInvoiceBtn').addEventListener('click', function(e) {
                e.preventDefault();
                const url = "{{ route('invoice.print', $order->id) }}";
                window.open(url, '_blank');
            });
        </script>
    @endsection
