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
            background: #f8f9fa;
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
            padding-left: 40px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            text-align: left;
        }

        .account-content h1,
        .account-content h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }

        .account-content p,
        .account-content .text-muted {
            margin-bottom: 10px;
            color: #555;
        }

        /* --- Buttons --- */
        .account-buttons a,
        .btn-primary {
            display: inline-block;
            padding: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 3px;
            font-weight: 500;
            background: #1e72df;
            color: #ffffff;
            transition: 0.3s;
            text-align: center;
            text-decoration: none;
        }

        .account-buttons a:hover,
        /* .btn-primary:hover {
                                                                                    color: #ffffff;
                                                                                    background-color: rgb(44, 43, 43);
                                                                                    text-decoration: none;
                                                                                } */

        /* --- Form controls --- */
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
    </style>

    <div class="container account-container">
        <div class="row">
            <!-- Top Title -->
            <div class="col-12 account-header">
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
            <div class="col-md-9 account-content">
                <h2 class="text-secondary">Billing address</h2>
                <form method="POST" action="{{ route('customer.address.store') }}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 mt-2">
                            <label for="firstName">First name *</label>
                            <input type="text" name="first_name" class="form-control" id="firstName"
                                value="{{ old('first_name', $billingAddress->first_name ?? '') }}" required>
                        </div>
                        <div class="form-group col-md-6 mt-2">
                            <label for="lastName">Last name (optional)</label>
                            <input type="text" name="last_name" class="form-control" id="lastName"
                                value="{{ old('last_name', $billingAddress->last_name ?? '') }}">
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="streetAddress mt-2">Street address *</label>
                        <input type="text" name="street_address" class="form-control" id="streetAddress"
                            value="{{ old('street_address', $billingAddress->street_address ?? '') }}"
                            placeholder="House number and street name" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="townCity">Town/City *</label>
                        <input type="text" name="town" class="form-control" id="townCity"
                            value="{{ old('town', $billingAddress->town ?? '') }}" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="phone">Phone *</label>
                        <input type="tel" name="phone" class="form-control" id="phone"
                            value="{{ old('phone', $billingAddress->phone ?? '') }}" required>
                    </div>

                    <div class="form-group mt-2">
                        <label for="email">Email address *</label>
                        <input type="email" name="email" class="form-control" id="email"
                            value="{{ old('email', $billingAddress->email ?? '') }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2 fw-bold">SAVE ADDRESS</button>
                </form>
            </div>
        </div>






        @include('Landing-Page.partials.products')
    @endsection
