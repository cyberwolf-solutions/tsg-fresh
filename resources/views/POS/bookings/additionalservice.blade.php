@extends('layouts.master-without-nav')

@section('title')
    Print Order
@endsection

@section('content')
    <style>
        body {
            background-color: #FFF !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="row my-2 justify-content-center text-center">
                <img src="{{ asset('storage/' . $settings->logo_dark) }}" class="img-fluid w-25" alt="">
                <span class="fs-5">TSG fresh Resort</span>
            </div>
            <div class="row justify-content-between mt-5">
                <div class="col">
                    <h6>Checkout No</h6>
                    <span>#{{ $settings->invoice($checkinCheckout->id) }}</span>
                </div>
                <div class="col">
                    <h6>Checkout Date</h6>
                    <span>{{ \Carbon\Carbon::parse($checkinCheckout->checkin)->format($settings->date_format) }}</span>
                </div>

                <div class="col">
                    <h6>Checkout Date</h6>
                    <span>{{ \Carbon\Carbon::parse($checkinCheckout->checkout)->format($settings->date_format) }}</span>
                </div>

            </div>
            {{-- <hr> --}}
            <div class="row mt-4">
                <div class="col">
                    <h6>Customer</h6>
                    @if ($checkinCheckout->customer_id == 0)
                        <p>Walking Customer</p>
                    @else
                        <p>{{ $checkinCheckout->customer->name }},</p>
                        <p>{{ $checkinCheckout->customer->contact }},</p>
                        <p>{{ $checkinCheckout->customer->email }},</p>
                        <p>{{ $checkinCheckout->customer->address }}.</p>
                    @endif
                </div>
                @if ($checkinCheckout->room_no != 0)
                    <div class="col">

                    </div>
                @endif

            </div>
            <hr>
            <div class=" col-12">
                <table class="table table-hover align-middle ">
                    <thead>
    
                        <th>Service</th>
                        <th>Price</th>
                    </thead>
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach ($additionalServices as $service)
                            <tr>
                                <td>{{ $service['name'] }}</td>
                                <td>@if ($checkinCheckout->customer->currency->name == 'LKR')
                                    Rs.
                                @elseif ($checkinCheckout->customer->currency->name == 'USD')
                                    $
                                @elseif ($checkinCheckout->customer->currency->name == 'EUR')
                                    €
                                @endif {{ number_format($service['price'], 2) }}</td>
                                @php
                                    $subtotal += $service['price'];
                                @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td>
                                <h5 class="fw-bold">Sub Total</h5>
                            </td>
                            <td>
                                <h5 class="fw-bold">@if ($checkinCheckout->customer->currency->name == 'LKR')
                                    Rs.
                                @elseif ($checkinCheckout->customer->currency->name == 'USD')
                                    $
                                @elseif ($checkinCheckout->customer->currency->name == 'EUR')
                                    €
                                @endif
                                    {{ number_format($subtotal, 2) }}</h5>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>
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
