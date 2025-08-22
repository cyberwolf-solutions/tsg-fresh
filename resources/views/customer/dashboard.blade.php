@extends('landing-page.layouts.app')
@section('content')
    <style>
        /* Page container */
        .account-container {
            margin-top: 100px;
            margin-bottom: 30px;
            min-height: calc(100vh - 150px);
        }

        /* Title section */
        .account-header {
            background-color: #f9f9f9;
            padding: 25px 0;
            text-align: center;
            margin-bottom: 30px;
            width: 100vw;
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

        /* Sidebar */
        .account-sidebar {
            text-align: center;
            border-right: 1px solid #e5e5e5;
            padding: 20px;
        }

        .account-sidebar img {
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

        /* Content */
        .account-content {
            padding-left: 40px;
        }

        .account-content .welcome-text {
            margin-bottom: 25px;
            font-size: 14px;
            color: #555;
        }

        .account-content .welcome-text a {
            color: #0073aa;
            text-decoration: none;
        }

        /* Buttons */
        .account-buttons a {
            display: inline-block;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-weight: 500;
            background: #fff;
            color: #333;
            transition: 0.3s;
            text-align: center;
            width: 100%;
            text-decoration: none;
        }

        .account-buttons a:hover {
            /* border-color: #0073aa; */
            color: #ffffff;
            background-color: rgb(44, 43, 43);
            text-decoration: none;
        }
    </style>


    <div class="container account-container">
        <div class="row">
            <!-- Top Title -->
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
                    <a href="{{ route('customer.dashboard') }}" class="active">Dashboard</a>
                    <a href="{{ route('customer.order.index') }}" class="active">Orders</a>
                    <a href="#">Downloads</a>
                    <a href="{{ route('customer.address') }}">Addresses</a>
                    <a href="{{ route('customer.account') }}">Account details</a>
                    <a href="#" class="text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 account-content">
                <div class="welcome-text">
                    <p>
                        Hello <strong>{{ Auth::guard('customer')->user()->email }}</strong> (not
                        {{ Auth::guard('customer')->user()->email }}?
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Log out
                        </a>)
                    </p>
                    <p>
                        From your account dashboard you can view your recent orders, manage your shipping and billing
                        addresses, and edit your password and account details.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="row account-buttons g-3">
                    <div class="col-md-4 col-6">
                        <a href="#">Orders</a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="#">Downloads</a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="{{ route('customer.address') }}">Addresses</a>
                    </div>
                    <div class="col-md-4 col-6">
                        <a href="{{ route('customer.account') }}">Account details</a>
                    </div>
                </div>
            </div>
        </div>



       @include('Landing-Page.partials.products')
    @endsection
