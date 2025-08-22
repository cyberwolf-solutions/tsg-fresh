@extends('landing-page.layouts.app')
@section('content')
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .account-container {
            margin-top: 100px;
            margin-bottom: 30px;
            min-height: calc(100vh - 150px);
        }

        .account-header {
            background: #f9f9f9;
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

        .account-sidebar {
            text-align: center;
            border-right: 1px solid #e5e5e5;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            height: fit-content;
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
            border-bottom: 1px solid #fff;
            text-align: left;
        }

        .account-sidebar nav a.active {
            color: #0073aa;
            font-weight: bold;
            border-right: 3px solid #0073aa;
            background: #fff;
        }

        .account-content {
            padding-left: 40px;
            background: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .order-table th {
            background-color: #f8f9fa;
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }

        .order-table td {
            padding: 16px 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .order-table tr:hover {
            background-color: #f8f9fa;
        }

        .order-number {
            color: #007bff;
            font-weight: 500;
        }

        .order-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }

        .status-on-hold {
            background-color: #fff3cd;
            color: #856404;
        }

        .order-total {
            font-weight: 600;
            color: #2c2c2c;
        }

        .order-items {
            color: #6c757d;
            font-size: 13px;
        }

        .btn-view {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 5px 15px;
            border-radius: 4px;
            font-size: 14px;
            color: #495057;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background-color: #e9ecef;
            color: #212529;
        }

        .btn-invoice {
            background-color: #007bff;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.2s;
        }

        .btn-invoice:hover {
            background-color: #0069d9;
            color: white;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 992px) {
            .account-sidebar {
                border-right: none;
                border-bottom: 1px solid #e5e5e5;
                margin-bottom: 20px;
            }

            .account-content {
                padding-left: 15px;
            }
        }

        @media (max-width: 768px) {
            .order-table {
                font-size: 14px;
            }

            .order-table th,
            .order-table td {
                padding: 10px 8px;
            }

            .btn-view,
            .btn-invoice {
                padding: 4px 8px;
                font-size: 12px;
            }
        }
    </style>

    <div class="container account-container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 account-sidebar">
                <img src="#" alt="Profile Image">
                <div class="username">{{ $webCustomer->first_name }} #{{ $webCustomer->id }}</div>
                <nav>
                    <a href="{{ route('customer.dashboard') }}">Dashboard</a>
                    <a href="{{ route('customer.order.index') }}" class="active">Orders</a>
                    <a href="{{ route('customer.address') }}">Addresses</a>
                    <a href="{{ route('customer.address') }}">Download</a>
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
            <!-- Main Content -->
            <div class="col-lg-9 col-md-8 account-content">
                <h3 class="mb-4">My Orders</h3>

                <div class="table-responsive">
                    <table class="order-table">
                        <thead>
                            <tr>
                                <th>ORDER</th>
                                <th>DATE</th>
                                <th>STATUS</th>
                                <th>TOTAL</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td class="order-number">#{{ $order->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</td>
                                    <td>
                                        @php
                                            $statusColor = match (strtolower($order->status)) {
                                                'completed' => 'background-color: #d4edda; color: #155724;',
                                                'processing' => 'background-color: #d1ecf1; color: #0c5460;',
                                                'on hold' => 'background-color: #fff3cd; color: #856404;',
                                                default => 'background-color: #f8d7da; color: #721c24;',
                                            };
                                        @endphp
                                        <span class="order-status" style="{{ $statusColor }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="order-total">රු{{ number_format($order->total + ($order->delivery_fee ?? 0), 2) }}</span>
                                        <div class="order-items">
                                            for {{ $order->items->count() }}
                                            {{ Str::plural('item', $order->items->count()) }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" class="btn-view">VIEW</a>
                                        <a href="#" class="btn-invoice">TAX
                                            INVOICE</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-muted text-center">You have no orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        @include('Landing-Page.partials.products')
    </div>
@endsection
