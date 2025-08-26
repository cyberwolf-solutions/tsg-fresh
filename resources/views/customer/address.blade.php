@extends('landing-page.layouts.app')
@section('content')
    <style>
        /* --- Page container --- */
        .account-container {
            margin-top: 100px;
            margin-bottom: 30px;
            min-height: calc(100vh - 150px);
        }

        /* --- Title section --- */
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
            border-bottom: 1px solid #ffffff;
            text-align: left;
        }

        .account-sidebar nav a.active {
            color: #0073aa;
            font-weight: bold;
            border-right: 3px solid #0073aa;
            background: #ffffff;
        }

        .account-sidebar nav a:hover {
            color: #0073aa;
        }

        /* --- Content --- */
        .account-content {
            padding-left: 40px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
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

        .account-content h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }

        .account-content p {
            margin-bottom: 10px;
            color: #555;
        }

        /* --- Buttons --- */
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
                    <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                    <a href="{{ route('customer.order.index') }}" class="">Orders</a>
                    <a href="{{ route('customer.download') }}">Downloads</a>
                    <a href="{{ route('customer.address') }}" class="active">Addresses</a>
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
            <div class="col-md-9 account-content text-start">
                <p class="text-muted">The following addresses will be used on the checkout page by default.</p>

                <h1 class="text-secondary">Billing address</h1>

                @if ($billingAddress)
                    <p>
                        <a href="{{ route('customer.address.create', $billingAddress->id) }}"
                            class="text-secondary text-decoration-none">
                            Edit Billing address
                        </a>
                    </p>

                    <p>{{ $billingAddress->first_name }} {{ $billingAddress->last_name }}</p>
                    <p>{{ $billingAddress->street_address }}</p>
                    <p>{{ $billingAddress->town }}</p>
                    <p>{{ $billingAddress->phone }}</p>
                    <p>{{ $billingAddress->email }}</p>
                @else
                    <p><a href="{{ route('customer.address.create') }}">Add Billing address</a></p>
                    <p class="text-muted">You have not set up this type of address yet.</p>
                @endif
            </div>
        </div>



        @include('Landing-Page.partials.products')
    @endsection
