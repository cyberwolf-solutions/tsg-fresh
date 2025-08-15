@extends('landing-page.layouts.app')
@section('content')
    <style>
        .account-sidebar nav a.active {
            color: #007bff;
            font-weight: bold;
            /* background-color: rgba(0, 123, 255, 0.05); */
            border-right: 3px solid #007bff;
            padding-left: 10px;
            margin-left: -10px;
        }

        .footer {
            font-family: Arial, sans-serif;
        }

        .footer h5 {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .product-item p {
            margin: 0;
            font-size: 14px;
            color: #555;
            line-height: 1.4;
        }

        .price {
            font-weight: bold;
            color: #222;
            margin-top: 2px;
        }

        .account-sidebar {
            text-align: center;
            padding: 20px;
            border-right: 1px solid #ddd;
        }

        .account-sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: #f1f1f1;
            display: block;
            margin: 0 auto 10px;
        }

        .account-sidebar .username {
            font-weight: 600;
        }

        .account-sidebar nav a {
            display: block;
            padding: 8px 0;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        .account-sidebar nav a.active {
            font-weight: bold;
        }

        .account-sidebar nav a:hover {
            color: #0073aa;
        }

        .account-content h1 {
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .account-content h2 {
            font-size: 14px;
            font-weight: normal;
            text-align: center;
            color: #777;
            margin-bottom: 30px;
        }

        .account-content .welcome-text {
            margin-bottom: 20px;
            /* font-size: 14px; */
        }

        .account-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .account-buttons a {
            flex: 1;
            min-width: 150px;
            text-align: center;
            padding: 15px 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            background: #fff;
            color: #333;
            transition: 0.3s;
        }

        .account-buttons a:hover {
            border-color: #0073aa;
            color: #0073aa;
        }

        .account-container {
            padding-top: 30px;
            min-height: calc(100vh - 150px);
            /* Adjust based on your header height */
        }

        .account-title {
            margin-bottom: 20px;
            /* font-size: 3rem; */
        }

        .dashboard-title {
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .account-sidebar {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }

        .profile-image {
            border-radius: 50%;
            margin-bottom: 15px;
        }

        .username {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .account-sidebar nav a {
            display: block;
            padding: 8px 0;
            color: #333;
            text-decoration: none;
        }

        .account-sidebar nav a:hover,
        .account-sidebar nav a.active {
            color: #007bff;
        }

        .account-content {
            padding-left: 30px;
        }

        .account-buttons a {
            margin-right: 10px;
            margin-bottom: 10px;
        }

        /* Custom styling for the navigation */
        nav a {
            text-decoration: none;
            color: #333;
            transition: all 0.2s ease;
        }

        nav a:hover,


        nav hr {
            border-top-width: 1px;
            margin: 0.25rem 0;
            /* Very tight spacing */
        }

        .account-content {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 5px;
            display: block;
        }

        .form-control {
            border-radius: 4px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            width: 100%;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
        }

        h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .btn-primary {
            padding: 10px 25px;
            font-weight: 500;
        }

        small.text-muted {
            font-size: 0.85rem;
            color: #6c757d;
            display: block;
            margin-top: 5px;
        }

        .account-content {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .account-content p {
            margin-bottom: 10px;
        }

        .account-content h2 {
            margin-bottom: 10px;
        }
    </style>
    <div class="container account-container" style="margin-top: 100px; margin-bottom: 30px;">
        <div class="row">
            <div class="text-center mb-4" style="background-color: #f5efef">
                <h3 class="account-title text-secondary fw-bold mt-2">MY ACCOUNT</h3>
                <h6 class=" text-secondary small mt-0">DASHBOARD
                </h6>
            </div>
            <!-- Sidebar -->
            <div class="col-md-1">

            </div>
            <div class="col-md-3 account-sidebar">

                <div class="username">
                    <img src="#" alt="" class="profile-image">
                    {{ Auth::guard('customer')->user()->first_name }} #1883
                </div>
                <nav class="mt-3 text-start">
                    <a href="{{ route('customer.dashboard') }}" class="d-block py-2 ">Dashboard</a>
                    <hr class="my-1 text-secondary opacity-25">
                    <a href="#" class="d-block py-2">Orders</a>
                    <a href="#" class="d-block py-2">Downloads</a>
                    <a href="{{ route('customer.address') }}" class="d-block py-2 active">Addresses</a>
                    <a href="{{ route('customer.account') }}" class="d-block py-2 ">Account details</a>
                    <hr class="my-1 text-secondary opacity-25">
                    <a href="#" class="d-block py-2 text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <div class="col-md-8 account-content text-start align-items-start">
                <p class="text-muted">The following addresses will be used on the checkout page by default.</p>
                <h1 class="text-start text-secondary fw-bold">Billing address</h1>

                @if ($billingAddress)
                    <p>
                        <a href="{{ route('customer.address.create', $billingAddress->id) }}"
                            class="text-secondary mt-1">Edit
                            Billing address</a>
                    </p>
                    <p>{{ $billingAddress->first_name }} {{ $billingAddress->last_name }}</p>
                    <p>{{ $billingAddress->street_address }}</p>
                    <p>{{ $billingAddress->town }}</p>
                    <p>{{ $billingAddress->phone }}</p>
                    <p>{{ $billingAddress->email }}</p>
                @else
                    <p><a href="{{ route('customer.address.create') }}" class="text-secondary mt-1">Add Billing address</a>
                    </p>
                    <p class="text-muted italic">You have not set up this type of address yet.</p>
                @endif
            </div>
        </div>
    </div>



    <footer class="footer ml-4">
        <div class="container ">
            <div class="row" style="margin-left: 60px; margin-right: 60px;">
                <!-- Latest Products -->
                <div class="col-md-4 ml-4">
                    <div class="footer-widget">
                        <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">LATEST</h5>
                        <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                            class="mb-4">


                        <div class="footer-product mt-2"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Best Selling -->
                <div class="col-md-4 ml-4">
                    <div class="footer-widget">
                        <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">BEST SELLING
                        </h5>
                        <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                            class="mb-4">


                        <div class="footer-product mt-2"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Rated -->
                <div class="col-md-4 ml-4">
                    <div class="footer-widget">
                        <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">TOP RATED</h5>
                        <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                            class="mb-4">


                        <div class="footer-product mt-2"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
