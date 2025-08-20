@extends('landing-page.layouts.app')
@section('content')
    <style>
        /* Reuse styles from account page */
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

        .order-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            padding: 15px;
            background: #fefefe;
        }

        .order-card h5 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-total {
            text-align: right;
            font-weight: bold;
            margin-top: 10px;
        }

        .text-status {
            font-weight: 600;
            color: #0073aa;
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
            <div class="col-md-9 account-content text-start">
                <h3 class="mb-4">My Orders</h3>

                @forelse($orders as $order)
                    <div class="order-card">
                        <h5>Order #{{ $order->id }} - <span class="text-status">{{ $order->status }}</span></h5>
                        <p>Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('d/m/Y H:i') }}</p>
                        <p>Delivery Method: {{ $order->delivery_method }} @if ($order->delivery_fee)
                                (රු{{ number_format($order->delivery_fee, 2) }})
                            @endif
                        </p>

                        <div class="order-items mt-2 mb-2">
                            @foreach ($order->items as $item)
                                <div class="order-item">
                                    <div>{{ $item->product->name ?? 'Product' }} x {{ $item->quantity }}</div>
                                    <div>රු{{ number_format($item->total, 2) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="order-total">
                            Subtotal: රු{{ number_format($order->subtotal, 2) }} <br>
                            Discount: රු{{ number_format($order->discount, 2) }} <br>
                            VAT: රු{{ number_format($order->vat, 2) }} <br>
                            <strong>Total: රු{{ number_format($order->total + $order->delivery_fee, 2) }}</strong>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">You have no orders yet.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
