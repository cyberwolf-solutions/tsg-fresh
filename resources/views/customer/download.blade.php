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
                    <a href="{{ route('customer.order.index') }}" class="">Orders</a>
                    <a href="{{ route('customer.download') }}" class="active">Downloads</a>
                    <a href="{{ route('customer.address') }}">Addresses</a>
                    <a href="{{ route('customer.account') }}">Account details</a>
                    <a href="#" class="text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 account-content">

                <h4 class="text-secondary small">No downloads available yet.</h4>

                @if (session('success'))
                    <div class="alert alert-success mt-2">{{ session('success') }}</div>
                @endif
            </div>
        </div>



        @include('Landing-Page.partials.products')
    @endsection
