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
    </style>

    <!-- Sidebar -->
    <style>
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
    </style>
    <style>
        /* Add this CSS to your stylesheet */
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
                    <a href="{{ route('customer.dashboard') }}" class="d-block py-2 active">Dashboard</a>
                    <hr class="my-1 text-secondary opacity-25"> <!-- Tight, subtle hr -->
                    <a href="{{ route('customer.dashboard') }}" class="d-block py-2">Orders</a>
                    <a href="{{ route('customer.dashboard') }}" class="d-block py-2">Downloads</a>
                    <a href="{{ route('customer.address') }}" class="d-block py-2">Addresses</a>
                    <a href="{{ route('customer.account') }}" class="d-block py-2">Account details</a>
                    <hr class="my-1 text-secondary opacity-25"> <!-- Second hr before logout -->
                    <a href="#" class="d-block py-2 text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Content -->
            <div class="col-md-8 account-content">

                <div class="welcome-text">
                    <p class="mb-4 text-secondary">
                        Hello {{ Auth::guard('customer')->user()->email }} (not
                        {{ Auth::guard('customer')->user()->email }}?
                        <a class="text-secondary" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>
                    </p>
                    <p class="text-secondary small">
                        From your account dashboard you can view your recent orders, manage your shipping and billing
                        addresses,
                        and edit your password and account details.
                    </p>
                </div>
                <div class="row account-buttons mt-4 g-2">
                    <div class="col-md-3 col-6">
                        <a href="#" class="btn btn-outline-secondary w-100">Orders</a>

                    </div>
                    <div class="col-md-3 col-6">
                        <a href="#" class="btn btn-outline-secondary w-100">Downloads</a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('customer.address') }}" class="btn btn-outline-secondary w-100">Addresses</a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{ route('customer.account') }}" class="btn btn-outline-secondary w-100">Account
                            details</a>
                    </div>
                </div>
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
