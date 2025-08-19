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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 0.5rem;
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
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
    <div class="container account-container" style="margin-top: 100px;">
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
                    <hr class="my-1 text-secondary opacity-25"> <!-- Tight, subtle hr -->
                    <a href="{{ route('customer.dashboard') }}" class="d-block py-2">Orders</a>
                    <a href="{{ route('customer.dashboard') }}" class="d-block py-2">Downloads</a>
                    <a href="{{ route('customer.address') }}" class="d-block py-2 active">Addresses</a>
                    <a href="{{ route('customer.account') }}" class="d-block py-2 ">Account details</a>
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

            <div class="col-md-8 account-content">
                <h2 class="text-start h2">Billing address</h2>
                <form method="POST" action="{{ route('customer.address.store') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="firstName">First name *</label>
                            <input type="text" name="first_name" class="form-control" id="firstName"
                                value="{{ old('first_name', $billingAddress->first_name ?? '') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastName">Last name (optional)</label>
                            <input type="text" name="last_name" class="form-control" id="lastName"
                                value="{{ old('last_name', $billingAddress->last_name ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="streetAddress">Street address *</label>
                        <input type="text" name="street_address" class="form-control" id="streetAddress"
                            value="{{ old('street_address', $billingAddress->street_address ?? '') }}"
                            placeholder="House number and street name" required>
                    </div>

                    <div class="form-group">
                        <label for="townCity">Town/City *</label>
                        <input type="text" name="town" class="form-control" id="townCity"
                            value="{{ old('town', $billingAddress->town ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone *</label>
                        <input type="tel" name="phone" class="form-control" id="phone"
                            value="{{ old('phone', $billingAddress->phone ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email address *</label>
                        <input type="email" name="email" class="form-control" id="email"
                            value="{{ old('email', $billingAddress->email ?? '') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary">SAVE ADDRESS</button>
                </form>

            </div>
        </div>
    </div>



    <footer class="footer bg-light py-4">
        <div class="container ml-4 ">

            <div class="row ml-4">
                <!-- LATEST -->
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3 text-secondary">LATEST</h5>
                    <div class="product-item d-flex">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Clean Prawns"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">CLEAN PRAWNS 31-40 m2 k</p>
                            <p class="price">6,3850.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Whole Prawns"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">WHOLE PRAWNS JUMBO-HEADLESS</p>
                            <p class="price">6,3900.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg"
                            alt="Clean Prawns Small" class="me-3"
                            style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">CLEAN PRAWNS SMALL 500G.</p>
                            <p class="price">6,1700.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Whole Crab"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">WHOLE CRAB 1KG</p>
                            <p class="price">6,2360.00</p>
                        </div>
                    </div>
                </div>

                <!-- BEST SELLING -->
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3 text-secondary">BEST SELLING</h5>
                    <div class="product-item d-flex">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Clean Prawns"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">CLEAN PRAWNS</p>
                            <p class="price">From: 6,3400.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Squid"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">SQUID</p>
                            <p class="price">From: 6,1525.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Thalapath Fish"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">THALAPATH FISH</p>
                            <p class="price">From: 6,2006.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Tuna Cube"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">Tuna Cube - 500G</p>
                            <p class="price">6,1711.00</p>
                        </div>
                    </div>
                </div>

                <!-- TOP RATED -->
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3 text-secondary">TOP RATED</h5>
                    <div class="product-item d-flex">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Cooked PDTO"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">COOKED PDTO SMALL 1KG</p>
                            <p class="price">6,2500.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Red Snapper"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">RED SNAPPER 500G</p>
                            <p class="price">6,1180.00</p>
                        </div>
                    </div>
                    <div class="product-item d-flex mt-3">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg" alt="Red Snapper"
                            class="me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        <div>
                            <p class="mb-1">RED SNAPPER 1KG</p>
                            <p class="price">6,2360.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
