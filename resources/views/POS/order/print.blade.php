@extends('layouts.master-without-nav')

@section('title')
    Print Order
@endsection

@section('content')
    <style>
        body {
            background-color: #FFF !important;
            font-family: Arial, sans-serif;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .invoice-header img {
            max-height: 80px;
        }

        .invoice-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .invoice-info h6 {
            margin: 0;
            font-weight: 600;
        }

        .invoice-info span {
            display: block;
        }

        .invoice-table th, .invoice-table td {
            font-size: 0.9rem;
            padding: 8px;
        }

        .invoice-table thead th {
            background-color: #000;
            color: #fff;
        }

        .invoice-table tfoot td {
            font-weight: 600;
        }

        .grand-total {
            background-color: rgba(55, 140, 231, 0.1);
            padding: 15px;
            border-radius: 5px;
        }
    </style>

    <div class="container-fluid">
        <!-- Header -->
        <div class="invoice-header">
            <div>
                <img src="{{ asset('build/images/landing/flogo.png') }}" alt="Logo" class="img-fluid">
            </div>
            <div class="text-end">
                <div>TAPROBANE FRESH</div>
                <div>#105/A/2, Dharmashoka Mawatha, Kandy</div>
                <div>+9477 2222 654 | +9476 1358 631</div>
            </div>
        </div>

        <!-- Invoice Info -->
        <div class="row invoice-info mb-4">
            <div class="col-md-6">
                <h6>Invoice Number:</h6>
                <span>{{ $settings->invoice($data->id) }}</span>
                <h6>Invoice Date:</h6>
                <span>{{ \Carbon\Carbon::parse($data->order_date)->format('F d, Y') }}</span>
            </div>
            <div class="col-md-6 text-end">
                <h6>Order Number:</h6>
                <span>{{ $data->id }}</span>
                <h6>Order Date:</h6>
                <span>{{ \Carbon\Carbon::parse($data->order_date)->format('F d, Y') }}</span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Customer:</h6>
                @if ($data->customer_id == 0)
                    <p>Walking Customer</p>
                @else
                    <p >{{ $data->customer->name }}</p>
                    <p style="margin-top: -15px">{{ $data->customer->contact }}</p>
                    <p style="margin-top: -15px">{{ $data->customer->email }}</p>
                    <p style="margin-top: -15px">{{ $data->customer->address }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="row mb-4">
            <div class="col-12">
                <table class="table table-hover invoice-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Description</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->items as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $item->product->name }}
                                    @if($item->variant)
                                        - {{ $item->variant->variant_name }}
                                    @endif
                                    <br>
                                    <small class="text-muted">
                                        {{-- MFD: {{ $item->product->manufacture_date ? \Carbon\Carbon::parse($item->manufacture_date)->format('Y-m-d') : 'N/A' }}
                                        | EXP: {{ $item->product->expiry_date ? \Carbon\Carbon::parse($item->product->expiry_date)->format('Y-m-d') : 'N/A' }} --}}
                                        {{-- <br> --}}
                                        Categories: 
                                        @foreach($item->product->categories as $category)
                                            {{ $category->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </small>
                                </td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total, 2) }}</td>
                            </tr>

                           
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>Sub Total</td>
                            <td>Rs. {{ number_format($data->subtotal ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Discount</td>
                            <td>Rs. {{ number_format($data->discount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>VAT</td>
                            <td>Rs. {{ number_format($data->vat?? 0, 2) }} </td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td><h5>Grand Total</h5></td>
                            <td><h5>Rs. {{ number_format($data->total ?? 0, 2) }}</h5></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <small>Copyright 2025 © Taprobane Fresh – All Rights Reserved | Developed by CyberWolf Solutions (Pvt) Ltd.</small>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            window.print();
        });
    </script>
@endsection
