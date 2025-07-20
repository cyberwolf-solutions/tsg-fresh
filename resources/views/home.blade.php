@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('content')
   <div class="container mt-4">
    <div class="row g-3">
        <!-- Revenue -->
        <div class="col-12 col-md-3">
            <div class="card text-center p-3" style="border: none; border-radius: 20px; background-color: white;">
                <div class="card-body">
                    <div class="text-primary mb-2">
                        <i class="ri-money-dollar-circle-line" style="font-size: 2rem;"></i>
                    </div>
                    <p class="mb-1 text-primary small">Revenue</p>
                    {{-- <h5 class="mb-0 text-dark fw-semibold">LKR {{ number_format($revenue, 2) }}</h5> --}}
                    <h5 class="mb-0 text-dark fw-semibold">LKR 1000</h5>
                </div>
            </div>
        </div>

        <!-- Sale Return -->
        <div class="col-12 col-md-3">
            <div class="card text-center p-3" style="border: none; border-radius: 20px; background-color: white;">
                <div class="card-body">
                    <div class="text-danger mb-2">
                        <i class="ri-arrow-go-back-line" style="font-size: 2rem;"></i>
                    </div>
                    <p class="mb-1 text-danger small">Sale Return</p>
                    {{-- <h5 class="mb-0 text-dark fw-semibold">LKR {{ number_format($saleReturn, 2) }}</h5> --}}
                    <h5 class="mb-0 text-dark fw-semibold">LKR 1000</h5>

                </div>
            </div>
        </div>

        <!-- Purchase Return -->
        <div class="col-12 col-md-3">
            <div class="card text-center p-3" style="border: none; border-radius: 20px; background-color: white;">
                <div class="card-body">
                    <div class="text-warning mb-2">
                        <i class="ri-exchange-dollar-line" style="font-size: 2rem;"></i>
                    </div>
                    <p class="mb-1 text-warning small">Purchase Return</p>
                    {{-- <h5 class="mb-0 text-dark fw-semibold">LKR {{ number_format($purchaseReturn, 2) }}</h5> --}}
                    <h5 class="mb-0 text-dark fw-semibold">LKR 1000</h5>

                </div>
            </div>
        </div>

        <!-- Profit -->
        <div class="col-12 col-md-3">
            <div class="card text-center p-3" style="border: none; border-radius: 20px; background-color: white;">
                <div class="card-body">
                    <div class="text-success mb-2">
                        <i class="ri-line-chart-line" style="font-size: 2rem;"></i>
                    </div>
                    <p class="mb-1 text-success small">Profit</p>
                    {{-- <h5 class="mb-0 text-dark fw-semibold">LKR {{ number_format($profit, 2) }}</h5> --}}
                    <h5 class="mb-0 text-dark fw-semibold">LKR 1000</h5>

                </div>
            </div>
        </div>
    </div>
</div>





{{-- grapg --}}

<div class="container mt-4">
    <div class="row">
        <!-- Cash Flow Chart (75%) -->
        <div class="col-md-9 bg-white p-4 rounded-3 shadow-sm ">
            <h5 class="mb-3">Cash Flow</h5>
            <canvas id="cashFlowChart" height="200"></canvas>
        </div>

        <!-- Monthly Cash Pie Chart (25%) -->
        <div class="col-md-3 bg-white p-4 rounded-3 shadow-sm ps-3">
            <h5 class="mb-3">Monthly Cash</h5>
            <canvas id="monthlyCashPie" height="200"></canvas>
        </div>
    </div>
</div>



    
@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxCashFlow = document.getElementById('cashFlowChart').getContext('2d');
        const cashFlowChart = new Chart(ctxCashFlow, {
            type: 'line',  // or 'bar' if you prefer bars
            data: {
                labels: {!! json_encode($cashFlowLabels) !!}, // e.g. ['Jan', 'Feb', 'Mar', ...]
                datasets: [
                    {
                        label: 'Payment Received',
                        data: {!! json_encode($paymentsReceived) !!}, // array of numbers
                        borderColor: 'purple',
                        backgroundColor: 'rgba(128,0,128, 0.3)',
                        fill: true,
                        tension: 0.4,
                    },
                    {
                        label: 'Payment Sent',
                        data: {!! json_encode($paymentsSent) !!}, // array of numbers
                        borderColor: 'orange',
                        backgroundColor: 'rgba(255,165,0, 0.3)',
                        fill: true,
                        tension: 0.4,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            // format y-axis ticks with currency symbol
                            callback: function(value) {
                                return 'LKR ' + value.toLocaleString();
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                },
            }
        });

        const ctxPie = document.getElementById('monthlyCashPie').getContext('2d');
        const monthlyCashPie = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: {!! json_encode($monthlyCashLabels) !!}, // e.g. ['Cash', 'Credit', 'Others']
                datasets: [{
                    data: {!! json_encode($monthlyCashData) !!}, // numbers array
                    backgroundColor: [
                        'purple',
                        'orange',
                        '#6c757d', // grey or any other colors
                    ],
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                },
            }
        });
    });
</script>

    <script>
        $(document).ready(function() {
            // Check if the browser supports notifications
            if ('Notification' in window) {
                // Request permission to display notifications
                Notification.requestPermission();
            } else {
                alert('This browser does not support desktop notifications.');
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.datatable').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            var finalCount = {{ $customers->count() }};
            var currentCount = 0;
            var increment = 1;
            var speed = 10;

            var counter = setInterval(function() {
                $('.stock-change').text(currentCount);
                currentCount += increment;
                if (currentCount > finalCount) {
                    clearInterval(counter);
                }
            }, speed / finalCount);
        });
    </script>
    <script>
        $(document).ready(function() {
            var finalCount = {{ $employees->count() }};
            var currentCount = 0;
            var increment = 1;
            var speed = 10;

            var counter = setInterval(function() {
                $('.stock-change1').text(currentCount);
                currentCount += increment;
                if (currentCount > finalCount) {
                    clearInterval(counter);
                }
            }, speed / finalCount);
        });
    </script>
    <script>
        $(document).ready(function() {
            var finalCount = {{ $suppliers->count() }};
            var currentCount = 0;
            var increment = 1;
            var speed = 10;

            var counter = setInterval(function() {
                $('.stock-change2').text(currentCount);
                currentCount += increment;
                if (currentCount > finalCount) {
                    clearInterval(counter);
                }
            }, speed / finalCount);
        });
    </script>
@endsection
