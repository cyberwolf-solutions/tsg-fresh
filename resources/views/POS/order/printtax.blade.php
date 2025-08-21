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

        .invoice-table th,
        .invoice-table td {
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
                @if ($data->customer_id == 0 && !$data->web_customer_id)
                    <p>Walking Customer</p>
                @elseif ($data->customer_id)
                    {{-- Regular customer --}}
                    <p>{{ $data->customer->name }}</p>
                    <p style="margin-top: -15px">{{ $data->customer->contact }}</p>
                    <p style="margin-top: -15px">{{ $data->customer->email }}</p>
                    <p style="margin-top: -15px">{{ $data->customer->address }}</p>
                @elseif ($data->web_customer_id)
                    {{-- Web customer --}}
                    <p>{{ $data->webCustomer->first_name }} {{ $data->webCustomer->last_name }}</p>
                    <p style="margin-top: -15px">{{ $data->webCustomer->contact }}</p>
                    <p style="margin-top: -15px">{{ $data->webCustomer->email }}</p>
                    <p style="margin-top: -15px">{{ $data->webCustomer->address }}</p>
                    <h6 style="margin-top: 20px;margin-bottom:20px">Address:</h6>
                    @if ($data->webCustomer->billingAddress)
                        <p style="margin-top: -15px">
                            {{ $data->webCustomer->billingAddress->street_address }},
                            {{ $data->webCustomer->billingAddress->town }} <br>
                            {{ $data->webCustomer->billingAddress->phone }} <br>
                            {{ $data->webCustomer->billingAddress->email }}
                        </p>
                    @endif
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
                            <th>Price (without 18% vat)</th>
                            <th>Qty</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $vatRate = 18; // 18%
                        @endphp

                        @foreach ($data->items as $key => $item)
                            @php
                                $priceWithVat = $item->price;
                                $priceWithoutVat = $priceWithVat / (1 + $vatRate / 100);
                                $vatAmount = $priceWithVat - $priceWithoutVat;
                                $totalWithoutVat = $priceWithoutVat * $item->quantity;
                                $totalVat = $vatAmount * $item->quantity;
                                $totalWithVat = $priceWithVat * $item->quantity;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    {{ $item->product->name }}
                                    @if ($item->variant)
                                        - {{ $item->variant->variant_name }}
                                    @endif
                                </td>
                                <td>{{ number_format($priceWithoutVat, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($totalWithoutVat, 2) }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                    @php
                        $subTotalWithoutVat = $data->items->sum(function ($item) use ($vatRate) {
                            return ($item->price / 1.18) * $item->quantity;
                        });

                        $totalVatAmount = $data->items->sum(function ($item) use ($vatRate) {
                            return $item->price - ($item->price / 1.18) * $item->quantity;
                        });

                        $grandTotalWithVat = $data->total; // Already stored in DB
                    @endphp

                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td>Sub Total (Excl. VAT)</td>
                            <td>Rs. {{ number_format($subTotalWithoutVat, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>Total VAT (18%)</td>
                            <td>Rs. {{ number_format($totalVatAmount, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td>
                                <h5>Total (Incl. VAT)</h5>
                            </td>
                            <td>
                                <h5>Rs. {{ number_format($grandTotalWithVat, 2) }}</h5>
                            </td>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="row mt-5">
            <div class="col-12 text-center">
                <small>Copyright 2025 © Taprobane Fresh – All Rights Reserved | Developed by CyberWolf Solutions (Pvt)
                    Ltd.</small>
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
