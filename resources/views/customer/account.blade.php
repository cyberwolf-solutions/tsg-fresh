@extends('landing-page.layouts.app')
@section('content')
    <style>
        /* --- Container --- */
        .account-container {
            margin-top: 100px;
            margin-bottom: 50px;
            min-height: calc(100vh - 150px);
        }

        /* --- Header --- */
        .account-header {
            background-color: #f9f9f9;
            padding: 25px 0;
            text-align: center;
            margin-bottom: 30px;
            width: 100%;
        }

        .account-header h3 {
            font-size: 22px;
            font-weight: bold;
            color: #444;
            margin-bottom: 5px;
        }

        .account-header h6 {
            font-size: 13px;
            color: #777;
            text-transform: uppercase;
        }

        /* --- Sidebar --- */
        .account-sidebar {
            text-align: center;
            border-right: 1px solid #e5e5e5;
            padding: 20px;
            background: #ffffff;
            border-radius: 5px;
        }

        .account-sidebar img,
        .profile-image {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #f1f1f1;
            display: block;
            margin: 0 auto 10px;
        }

        .account-sidebar .username {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .account-sidebar nav a {
            display: block;
            padding: 10px 0;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            border-bottom: 1px solid #f1f1f1;
            text-align: left;
        }

        .account-sidebar nav a.active {
            color: #0073aa;
            font-weight: bold;
            border-right: 3px solid #0073aa;
            background: #f9f9f9;
        }

        .account-sidebar nav a:hover {
            color: #0073aa;
        }

        /* --- Content --- */
        .account-content {
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .account-content h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #444;
        }

        /* --- Form Controls --- */
        .form-group label,
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
            border-color: #0073aa;
            box-shadow: 0 0 0 0.2rem rgba(0, 115, 170, 0.25);
        }

        h5 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        /* --- Buttons --- */
        .btn-primary {
            display: inline-block;
            padding: 10px 25px;
            font-weight: 500;
            background-color: #0073aa;
            color: #fff;
            border: 1px solid #0073aa;
            border-radius: 3px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background-color: #005f86;
            border-color: #005f86;
            color: #fff;
        }

        small.text-danger {
            font-size: 0.85rem;
        }
    </style>

    <div class="container account-container">
        <div class="row">
            <!-- Header -->
            <div class="col-12 account-header mt-2">
                <h3>MY ACCOUNT</h3>
                <h6>DASHBOARD</h6>
            </div>

            <!-- Sidebar -->
            <div class="col-md-3 account-sidebar">
                <img src="#" alt="Profile Image">
                <div class="username">
                    {{ Auth::guard('customer')->user()->first_name }} #1883
                </div>
                <nav>
                    <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                    <a href="{{ route('customer.dashboard') }}">Orders</a>
                    <a href="{{ route('customer.dashboard') }}">Downloads</a>
                    <a href="{{ route('customer.address') }}">Addresses</a>
                    <a href="{{ route('customer.account') }}" class="active">Account details</a>
                    <a href="#" class="text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 account-content">
                <form method="POST" action="{{ route('customer.account.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6 form-group">
                            <label for="first_name" class="form-label small">First name *</label>
                            <input type="text" name="first_name" class="form-control" id="first_name"
                                value="{{ old('first_name', $customer->first_name) }}">
                            @error('first_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="last_name" class="form-label small">Last name *</label>
                            <input type="text" name="last_name" class="form-control" id="last_name"
                                value="{{ old('last_name', $customer->last_name) }}">
                            @error('last_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="display_name" class="form-label small">Display name *</label>
                        <input type="text" name="display_name" class="form-control" id="display_name"
                            value="{{ old('display_name', $customer->first_name . '.' . $customer->last_name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small">Email address *</label>
                        <input type="email" class="form-control" id="email" value="{{ $customer->email }}" readonly>
                    </div>

                    <h5 class="mb-3 text-secondary">PASSWORD CHANGE</h5>
                    <div class="mb-3">
                        <label for="current_password" class="form-label small">Current password</label>
                        <input type="password" name="current_password" class="form-control" id="current_password">
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label small">New password</label>
                        <input type="password" name="new_password" class="form-control" id="new_password">
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label small">Confirm new password</label>
                        <input type="password" name="new_password_confirmation" class="form-control"
                            id="new_password_confirmation">
                        @error('new_password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">SAVE CHANGES</button>
                </form>

                @if (session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
            </div>
        </div>



        <footer class="footer ml-4 mt-4">
            <div class="container mt-5">
                <div class="row mt-5" style="margin-left: 60px; margin-right: 60px; margin-top: 50px;">
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
                                        500g</h6>
                                    <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Rated -->
                    <div class="col-md-4 ml-4">
                        <div class="footer-widget">
                            <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">TOP RATED
                            </h5>
                            <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                                class="mb-4">


                            <div class="footer-product mt-2"
                                style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                                <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                    alt="Clean Jumbo Prawns"
                                    style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                                <div class="footer-product-info" style="flex: 1;">
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
                                    <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                        Prawns
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
