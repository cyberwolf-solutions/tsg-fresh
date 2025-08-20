@extends('layouts.panel')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <style>
        .highlight {
            background-color: rgb(255, 255, 0);
            color: black
        }
    </style>
    <!-- start page title -->
    <div class="col-12">
        <div class="card mb-1 mt-2" style="background-color: white; border-radius: 8px;margin-top:10px">
            <div class="card-body py-2 px-3">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Left: Home Button -->
                    <div>
                        <a href="{{ route('home') }}" class="btn btn-light btn-icon waves-effect waves-light"
                            data-bs-toggle="tooltip" title="Home">
                            <i class="mdi mdi-home label-icon align-middle fs-16"></i>
                        </a>
                    </div>

                    <!-- Right: Icons and User -->
                    <div class="d-flex align-items-center">

                        <!-- Cart -->
                        <a href="#" class="btn btn-icon btn-ghost-secondary rounded-circle me-2"
                            style="color: #6f42c1; border: none;">
                            <i class="ri-shopping-cart-2-line fs-22"></i>
                        </a>

                        <!-- Print -->
                        <a href="#" class="btn btn-icon btn-ghost-secondary rounded-circle me-2"
                            style="color: #6f42c1; border: none;" title="Print">
                            <i class="ri-printer-line fs-22"></i>
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('settings.index') }}" class="btn btn-icon btn-ghost-secondary rounded-circle me-2"
                            style="color: #6f42c1; border: none;" title="Settings">
                            <i class="ri-settings-3-line fs-22"></i>
                        </a>

                        <!-- Notifications -->
                        <div class="dropdown me-2">
                            <button type="button" class="btn btn-icon btn-ghost-secondary rounded-circle"
                                style="color: #6f42c1; border: none;" id="notificationDropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="ri-notification-3-line fs-22"></i>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                                <!-- Notifications content -->
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="dropdown me-2">
                            <button type="button" class="btn btn-icon btn-ghost-secondary rounded-circle"
                                style="color: #6f42c1; border: none;" data-bs-toggle="dropdown">
                                <i class="ri-global-line fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="?lang=en" class="dropdown-item">🇬🇧 English</a>
                                <a href="?lang=si" class="dropdown-item">🇱🇰 Sinhala</a>
                                <a href="?lang=ta" class="dropdown-item">🇮🇳 Tamil</a>
                            </div>
                        </div>

                        <!-- User -->
                        <div class="dropdown">
                            <button type="button" class="btn d-flex align-items-center" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="background-color: transparent;">
                                <img class="rounded-circle header-profile-user me-2"
                                    src="@if (Auth::user()->avatar != '') {{ URL::asset('public/storage/' . Auth::user()->avatar) }} @else {{ URL::asset('build/images/users/user-dummy-img.jpg') }} @endif"
                                    alt="Avatar" style="height: 32px; width: 32px;">
                                <span class="d-none d-xl-block text-dark fw-semibold">{{ Auth::user()->name }}</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('profile') }}"><i
                                        class="mdi mdi-account-circle text-muted me-1"></i> Profile</a>
                                <a class="dropdown-item" href="{{ route('settings.index') }}"><i
                                        class="mdi mdi-cog-outline text-muted me-1"></i> Settings</a>
                                <a class="dropdown-item" href="javascript:void();"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off text-muted me-1"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


        {{-- body --}}
        <div class="row position-relative  ">
            <div class="card mb-0 ps-0">
                {{-- <div class="card-body"> --}}
                <div class="row">
                    <div class="col-md-5 " style="min-height: 100%;">
                        <div class="row">
                            <div class="col-12 d-flex flex-wrap"
                                style="height: auto;padding-top:10px;padding-bottom:10px;margin-bottom:10px;margin-left:10px">
                                <div class="row p-1">
                                    <div class="col-12">


                                        <div class="row g-2 align-items-center">
                                            <!-- Customer Search Select2 -->
                                            <div class="col-6">
                                                <select id="customer" class="form-control"></select>
                                            </div>
                                            <!-- Customer Display Button -->
                                            <div class="col-6">
                                                <button id="customer-btn" class="btn btn-light btn-sm" disabled
                                                    style="min-width: 180px;">
                                                    <i class="mdi mdi-account me-1"></i>
                                                    <span id="customer-name">Select Customer</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-1">
                                        <div class="row overflow-auto gap-2" style="height: 50vh">
                                            <div class="col-12  position-relative">
                                                <div id="cartBody"></div>
                                                <div class="select-none bg-blue-gray-100 rounded flex flex-wrap content-center justify-center opacity-25 mt-5"
                                                    id="emptyCart">
                                                    <div class="w-full text-center">
                                                        <i class="ri-shopping-cart-2-line display-1"></i>
                                                        <p class="text-xl">
                                                            Cart is empty!
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row g-2">

                                                <!-- Row 1: Subtotal, Discount, Total -->
                                                <div class="col-12 border-bottom pb-2">
                                                    <div class="row g-2">
                                                        <div class="col-md-4 small">
                                                            <span class="text-muted">Subtotal</span><br>
                                                            <strong id="sub">LKR 0.00</strong>
                                                        </div>

                                                        <div class="col-md-4 small">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="text-muted">Discount</span><br>
                                                                    <strong id="discount_html">LKR 0.00</strong>
                                                                </div>
                                                                <a href="javascript:void(0)" class="btn btn-sm "
                                                                    data-ajax-popup="true" data-title="Edit Discount"
                                                                    data-size="lg"
                                                                    data-url="{{ route('restaurant.discount') }}">
                                                                    <i class="bi bi-pencil" style="color: #318CE7"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 small">
                                                            <span class="text-muted">Total</span><br>
                                                            <strong id="total_html">LKR 0.00</strong>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Row 2: Coupon, Tax, Shipping -->
                                                <div class="col-12 border-bottom pt-2 pb-2">
                                                    <div class="row g-2">
                                                        <div class="col-md-4 small">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="text-muted">Coupon</span><br>
                                                                    <strong id="coupon_html">LKR 0.00</strong>
                                                                </div>
                                                                <a href="javascript:void(0)" class="btn btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#couponModal">
                                                                    <i class="bi bi-pencil" style="color: #318CE7"></i>
                                                                </a>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 small">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="text-muted">VAT</span><br>
                                                                    <strong id="vat_html"> 0 %</strong>
                                                                </div>
                                                                <a href="javascript:void(0)" class="btn btn-sm"
                                                                    data-ajax-popup="true" data-title="Edit Tax"
                                                                    data-size="lg" data-url="">
                                                                    {{-- <i class="bi bi-pencil" style="color: #318CE7"></i> --}}

                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 small">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="text-muted">Shipping</span><br>
                                                                    <strong id="shipping_html">LKR 0.00</strong>
                                                                </div>
                                                                <a href="javascript:void(0)" class="btn btn-sm "
                                                                    data-ajax-popup="true" data-title="Edit Shipping"
                                                                    data-size="lg" data-url="">
                                                                    <i class="bi bi-pencil" style="color: #318CE7"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Grand Total -->
                                                <div class="col-12 pt-3 pb-3 rounded-3"
                                                    style="background-color: rgba(55, 140, 231, 0.1);">
                                                    <div class="row align-items-center">
                                                        <div class="col">
                                                            <span class="fs-4 fw-semibold text-dark">Grand Total</span>
                                                        </div>
                                                        <div class="col text-end">
                                                            <span class="fs-3 fw-bold text-dark" id="grand_total">LKR
                                                                0.00</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Checkout Button -->
                                                <div class="col-12 text-end mt-2">
                                                    <button class="btn btn-primary fw-bold px-4"
                                                        style="background-color: #378CE7;"
                                                        onclick="checkout()">Checkout</button>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- show --}}
                    <div class=" col-md-7">


                        <div class="row justify-content-center mb-3 mt-3">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-text text-white"
                                        style="background-color: #1793b8;border:none">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" id="product-search" class="form-control"
                                        style="border:none;background-color:rgb(247, 247, 247)"
                                        placeholder="Search by name, variant, category or price">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex flex-wrap overflow-auto gap-1 p-3 bg-light rounded-4"
                                    style="max-height: 60vh; min-height: 30vh;" id="setmenuContainer">

                                    @foreach ($items as $item)
                                        <div class="col-md-2 cursor-pointer meal-item shadow rounded-0 p-1"
                                            data-id="{{ $item->id }}"
                                            data-category="{{ $item->categories->pluck('id')->implode(',') }}"
                                            data-image="{{ URL::asset($item->product_image_url) }}"
                                            data-price="{{ $item->unit_price }}"
                                            style="background: #fff; border: 0px solid #e0e0e0;">

                                            <div class="card border-0 mb-2 rounded-2 overflow-hidden"
                                                style="height: 15vh;">
                                                <img src="{{ URL::asset($item->product_image_url) }}"
                                                    alt="{{ $item->full_name }}" class="card-img-top"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>

                                            <div class="text-center"
                                                style="background-color: #ffffff; border-radius: 0 0 10px 10px; padding: 1px;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="meal-name mb-1"
                                                            style="font-weight: 600; font-size: 0.9rem; color: #222;">
                                                            {{ $item->full_name }}
                                                        </h6>

                                                        <h6 class="pname mb-1"
                                                            style="font-weight: 600; font-size: 0.9rem; color: #222;"
                                                            hidden>
                                                            {{ $item->pname }}
                                                        </h6>

                                                        <h6 class="vname mb-1"
                                                            style="font-weight: 600; font-size: 0.9rem; color: #222;"
                                                            hidden>
                                                            {{ $item->varientid }}
                                                        </h6>

                                                        <small class="d-block text-muted" style="font-size: 0.55rem;">
                                                            MFD:
                                                            {{ $item->manufacture_date ? \Carbon\Carbon::parse($item->manufacture_date)->format('Y-m-d') : 'N/A' }}
                                                            &nbsp;&nbsp;|&nbsp;&nbsp;
                                                            EXP:
                                                            {{ $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : 'N/A' }}
                                                        </small>
                                                    </div>

                                                    <div class="col-12 mb-2 mt-1">
                                                        @foreach ($item->categories as $category)
                                                            <span class="badge bg-secondary me-1"
                                                                style="font-size: 0.65rem;">{{ $category->name }}</span>
                                                        @endforeach
                                                    </div>

                                                    <div class="col-12">
                                                        <p class="text-primary fw-semibold" style="font-size: 0.85rem;">
                                                            LKR. {{ number_format($item->unit_price, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="row text-center justify-content-center"
                        style="background-color: #f0f3f4; padding: 10px;margin-top:-20px">

                        <!-- Cash -->
                        <!-- Cash Button -->
                        <!-- Trigger -->
                        <div class="col-auto mb-2">
                            <div onclick="openCashPopup()" class="category-item"
                                style="background-color: #f95cc2; color: white; padding: 8px 16px; border-radius: 6px; cursor: pointer; display: inline-block; transition: 0.3s;">
                                <i class="ri-money-dollar-circle-line me-1"></i> Cash
                            </div>
                        </div>

                        <input type="hidden" name="total_bill" id="totalBillHidden">
                        <input type="hidden" name="cash_received" id="cashReceivedHidden">
                        <input type="hidden" name="cash_balance" id="cashBalanceHidden">
                        <input type="hidden" id="paymentTypeHidden" name="paymentType">
                        <input type="hidden" id="depositReceiptHidden" name="deposit_receipt">

                        <!-- Modal -->
                        <!-- Cash Payment Modal -->
                        <!-- Cash Payment Modal -->
                        <div class="modal fade" id="cashPaymentModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Cash Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label>Total Bill</label>
                                            <input type="text" id="totalBill" class="form-control" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Cash Received</label>
                                            <input type="number" id="cashReceived" class="form-control"
                                                placeholder="Enter cash received">
                                        </div>
                                        <div class="mb-2">
                                            <label>Balance</label>
                                            <input type="text" id="cashBalance" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-primary" id="saveCashBtn">Save
                                            Payment</button>
                                    </div>
                                </div>
                            </div>
                        </div>






                        {{-- deposite --}}
                        <div class="modal fade" id="depositModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Deposit Payment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-2">
                                            <label>Total Bill</label>
                                            <input type="text" id="depositTotalBill" class="form-control" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label>Receipt Number</label>
                                            <input type="text" id="depositReceiptNo" class="form-control">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="saveDeposit()">Save
                                            Deposit</button>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <!-- Card -->
                        <div class="col-auto mb-2">
                            <div onclick="openCardPayment()"
                                style="background-color: #6f42c1; color: white; padding: 8px 16px; border-radius: 6px; cursor: pointer; display: inline-block; transition: 0.3s;">
                                <i class="ri-bank-card-line me-1"></i> Card
                            </div>
                        </div>

                        <!-- Deposit -->
                        <!-- Deposit button -->
                        <div class="col-auto mb-2">
                            <div onclick="openDepositModal()"
                                style="background-color: #007bff; color: white; padding: 8px 16px; border-radius: 6px; cursor: pointer; display: inline-block; transition: 0.3s;">
                                <i class="ri-bank-line me-1"></i> Deposit
                            </div>
                        </div>


                        <!-- Cancel -->
                        <div class="col-auto mb-2">
                            <div onclick="cancelOrder()"
                                style="background-color: #dc3545; color: white; padding: 8px 16px; border-radius: 6px; cursor: pointer; display: inline-block; transition: 0.3s;">
                                <i class="ri-close-circle-line me-1"></i> Cancel
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="col-auto mb-2">
                            <div onclick="openRecentTransactions()"
                                style="background-color: #6c757d; color: white; padding: 8px 16px; border-radius: 6px; cursor: pointer; display: inline-block; transition: 0.3s;">
                                <i class="ri-history-line me-1"></i> Recent Transactions
                            </div>
                        </div>

                        <div class="col-auto mb-2">
                            <div style="background-color:#53cb6f; color:white; padding:8px 16px; border-radius:6px; cursor:pointer;"
                                onclick="openCashInHandModal()">
                                <i class="ri-money-dollar-circle-line me-1"></i> Cash in Hand
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="recentTransactionsModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Recent Transactions</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Customer</th>
                                                    <th>Items</th>
                                                    <th>Total</th>
                                                    <th>Payments</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentTransactionsTableBody">
                                                <!-- Filled dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>


                </div>
                {{-- </div> --}}
            </div>
        </div>


        {{-- cash in hand --}}

        <div class="modal fade" id="cashInHandModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cash in Hand</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label>Opening Cash</label>
                            <input type="number" class="form-control" id="openingCash" min="0">
                        </div>
                        <div class="mb-2">
                            <label>Total Cash Received</label>
                            <input type="number" class="form-control" id="totalCashReceived" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Closing Cash</label>
                            <input type="number" class="form-control" id="closingCash" min="0">
                        </div>
                        <div class="mb-2">
                            <label>Balance / Variance</label>
                            <input type="number" class="form-control" id="cashBalance" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="saveCashInHand()">Save</button>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Coupon Modal -->
        <div class="modal fade" id="couponModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter Coupon Code</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="coupon_code_input" class="form-control" placeholder="Coupon Code">
                        <div class="text-danger mt-2" id="coupon_error" style="display:none;"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="apply_coupon_btn">Apply</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- End modal -->

        <style>
            .modal {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    @endsection



    @section('script')
        <!-- jQuery must come first -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap (optional, after jQuery) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <script>
            console.log(myObject); // Check the value of myObject before accessing properties
            console.log(myObject.toLocaleString()); // Check if myObject is defined and has the toLocaleString method
        </script>
        <!-- JS Logic -->
        <script>
            var ptype;

            function openCashPopup() {
                // Get total from the span
                let totalBill = parseFloat(document.getElementById("grand_total").innerText.replace(/[^0-9.]/g, '')) || 0;

                document.getElementById("totalBill").value = totalBill.toFixed(2);
                document.getElementById("cashReceived").value = "";
                document.getElementById("cashBalance").value = "";
                document.getElementById("paymentTypeHidden").value = "";

                document.getElementById("saveCashBtn").onclick = function() {
                    let received = parseFloat(document.getElementById("cashReceived").value) || 0;
                    let balance = received - totalBill;

                    if (received < totalBill) {
                        alert("Cash received must be greater than or equal to total bill!");
                        return;
                    }

                    // Save to hidden fields for checkout
                    document.getElementById("totalBillHidden").value = totalBill.toFixed(2);
                    document.getElementById("cashReceivedHidden").value = received.toFixed(2);
                    document.getElementById("cashBalanceHidden").value = balance.toFixed(2);
                    document.getElementById("paymentTypeHidden").value = "Cash";

                    let modal = bootstrap.Modal.getInstance(document.getElementById('cashPaymentModal'));
                    modal.hide();
                };

                let modal = new bootstrap.Modal(document.getElementById('cashPaymentModal'));
                modal.show();
            }

            // Auto-calculate balance while typing
            document.getElementById("cashReceived").addEventListener("input", function() {
                let total = parseFloat(document.getElementById("totalBill").value) || 0;
                let received = parseFloat(this.value) || 0;
                let balance = received - total;
                document.getElementById("cashBalance").value = balance >= 0 ? balance.toFixed(2) : 0;
            });

            // Open Deposit Modal
            function openDepositModal() {
                let total = parseFloat(document.getElementById('grand_total').innerText.replace(/[^0-9.]/g, '')) || 0;
                document.getElementById('depositTotalBill').value = total.toFixed(2);
                document.getElementById('depositReceiptNo').value = "";

                let modal = new bootstrap.Modal(document.getElementById('depositModal'));
                modal.show();
            }

            // Save Deposit Payment to hidden fields
            function saveDeposit() {
                let receiptNo = document.getElementById('depositReceiptNo').value.trim();
                if (!receiptNo) {
                    alert('Please enter receipt number!');
                    return;
                }

                let total = parseFloat(document.getElementById('grand_total').innerText.replace(/[^0-9.]/g, '')) || 0;

                // Fill hidden fields for checkout
                document.getElementById('totalBillHidden').value = total.toFixed(2);
                document.getElementById('cashReceivedHidden').value = total.toFixed(2); // consider full amount received
                document.getElementById('cashBalanceHidden').value = 0;
                document.getElementById('paymentTypeHidden').value = 'Deposit';
                document.getElementById('depositReceiptHidden').value = receiptNo;

                let modal = bootstrap.Modal.getInstance(document.getElementById('depositModal'));
                modal.hide();
            }
        </script>
        <script>
            function openCardPayment() {
                // Grab total bill from POS panel
                let total = parseFloat(document.getElementById('grand_total').innerText.replace(/[^0-9.-]+/g, "")) || 0;

                // Fill hidden fields
                document.getElementById('totalBillHidden').value = total;
                document.getElementById('cashReceivedHidden').value = total; // assuming full card payment
                document.getElementById('cashBalanceHidden').value = 0;
                document.getElementById('paymentTypeHidden').value = 'Card';
                document.getElementById('depositReceiptHidden').value = ''; // not applicable for card

                alert("Card payment selected. Hidden fields filled for checkout.");
            }
        </script>
        <script>
            function beep() {
                var context = new AudioContext();
                var oscillator = context.createOscillator();
                oscillator.type = "sine";
                oscillator.frequency.value = 800;
                oscillator.connect(context.destination);
                oscillator.start();
                // Beep for 50 milliseconds
                setTimeout(function() {
                    oscillator.stop();
                }, 50);
            }
        </script>
        <script>
            var discount = 0;
            var discount_val = 0;
            var discount_method;

            // var vat = 0;
            var vat_val = 0;
            var vat_method;

            var customer = 0;
            var table = 0;
            var room = 0;

            var kitchen_note
            var bar_note
            var staff_note
            var payment_note

            var couponValue;

            $(document).ready(function() {
                $('#product-search').on('input', function() {
                    let query = $(this).val().toLowerCase();

                    $('#setmenuContainer .meal-item').each(function() {
                        let name = $(this).find('.meal-name').text().toLowerCase();
                        let variant = $(this).find('.vname').text().toLowerCase();

                        // Concatenate all category badge texts
                        let categories = '';
                        $(this).find('.badge').each(function() {
                            categories += $(this).text().toLowerCase() + ' ';
                        });

                        let price = $(this).find('.text-primary').text().toLowerCase();

                        if (name.includes(query) || variant.includes(query) || categories.includes(
                                query) || price.includes(query)) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            });

            $(document).ready(function() {


                $(document).on('click', '.meal-item', function() {
                    $('#loader').removeClass('d-none');

                    // alert("clicked");

                    // Check if customer is selected
                    if (customer === 0) {
                        display_error('Please select a customer first.');
                        $('#loader').addClass('d-none');
                        return;
                    }
                    // if (room === 0) {
                    //     display_error('Please select a Room first.');
                    //     $('#loader').addClass('d-none');
                    //     return;
                    // }



                    var id = $(this).data('id');
                    var mealName = $(this).find('.meal-name').text();
                    var pid = $(this).find('.pname').text();
                    var vid = $(this).find('.vname').text();
                    var image = $(this).data('image');
                    var price = $(this).data('price');
                    var quantity = 1;

                    if (cart.find(e => e.id == id)) {
                        display_error('Item is already in the cart');
                        $('#loader').addClass('d-none');
                        return;
                    }

                    cart.push({
                        id: id,
                        name: mealName,
                        pid: pid,
                        vid: vid,
                        image: image,
                        price: price,
                        quantity: quantity,
                    });

                    $('#loader').addClass('d-none');
                    console.log('Cart after push:', cart);
                    loadCart();
                });

                // When modal is hidden (closed), capture the input value
                $('#commonModal').on('hidden.bs.modal', function() {
                    kitchen_note = $('#kitchen_note').val();
                    bar_note = $('#bar_note').val();
                    staff_note = $('#staff_note').val();
                    payment_note = $('#payment_note').val();
                });


                // client-side filtering of products
                $('#searchInput').on('input', function() {
                    $('#loader').removeClass('d-none');

                    var searchText = $(this).val().toLowerCase();
                    var noResultsMessage = $('#noResultsMessage');

                    // Hide all meal items initially
                    $('.meal-item').hide();

                    $('.meal-item').each(function() {
                        var mealName = $(this).find('.meal-name');
                        var mealNameText = mealName.text().toLowerCase();

                        if (mealNameText.includes(searchText)) {
                            // Highlight matching text
                            var highlightedText = mealNameText.replace(new RegExp(searchText, 'gi'),
                                match => `<span class="highlight">${match}</span>`);
                            mealName.html(highlightedText);

                            $(this).show(); // Show matching meal item
                        } else {
                            mealName.html(mealNameText); // Reset original text
                        }
                    });

                    // Show no results message if no items are displayed
                    if ($('.meal-item:visible').length === 0) {
                        noResultsMessage.show();
                    } else {
                        noResultsMessage.hide();
                    }
                    $('#loader').addClass('d-none');

                });

                $('.category-item').click(function() {
                    $('#loader').removeClass('d-none');


                    var categoryId = $(this).data('id');
                    // Hide all menu items initially
                    $('.meal-item').hide();

                    if (categoryId === 0) {
                        // Show all menu items if categoryId is 0
                        $('.meal-item').show();
                    } else {
                        // Show menu items related to the selected category
                        $('.meal-item').each(function() {
                            var itemCategoryId = $(this).data('category');
                            if (itemCategoryId === categoryId) {
                                $(this).show();
                            }
                        });
                    }

                    // Show no results message if no items are displayed
                    if ($('.meal-item:visible').length === 0) {
                        $('#noResultsMessage').show();
                    } else {
                        $('#noResultsMessage').hide();
                    }
                    $('#loader').addClass('d-none');

                });


                $(document).on('change', '#customer', function() {
                    $('#customer-btn #name').text($(this).find(':selected').data('name'));
                    customer = $(this).find(':selected').val();

                    // Update the data-url attribute with the customer variable
                    var binding = "?customer=" + customer;
                    $('#customer-btn').attr('data-binding', binding); // Update the HTML attribute
                });

                $(document).on('change', '.table', function() {
                    $('#table-btn #name').text($(this).data('name'));
                    table = $(this).val();
                    // Update the data-url attribute with the table variable
                    var binding = "?table=" + table;
                    $('#table-btn').attr('data-binding', binding); // Update the HTML attribute
                });
                $(document).on('change', '.room', function() {
                    $('#room-btn #name').text($(this).data('name'));
                    room = $(this).val();
                    // Update the data-url attribute with the room variable
                    var binding = "?room=" + room;
                    $('#room-btn').attr('data-binding', binding); // Update the HTML attribute
                });





            });


            // $(document).ready(function() {
            //     $('#customer').select2({
            //         placeholder: 'Search Customer',
            //         ajax: {
            //             url: "{{ route('customers.search') }}",
            //             dataType: 'json',
            //             delay: 250,
            //             data: function(params) {
            //                 return { q: params.term };
            //             },
            //             processResults: function(data) {
            //                 console.log("Data from server:", data); // 🔥 debug here
            //                 return { results: data };
            //             },
            //             cache: true
            //         }
            //     });

            //     $('#customer').on('select2:select', function(e) {
            //         var data = e.params.data;
            //         console.log("Selected:", data); // 🔥 debug selected value
            //         var binding = "?customer=" + data.id;
            //         $('#customer-btn').attr('data-binding', binding);
            //     });
            // });

            // $(document).ready(function() {
            //     $('#customer').select2({
            //         placeholder: 'Search Customer',
            //         ajax: {
            //             url: "{{ route('customers.search') }}",
            //             dataType: 'json',
            //             delay: 250,
            //             data: function(params) {
            //                 return {
            //                     q: params.term
            //                 };
            //             },
            //             processResults: function(data) {
            //                 return {
            //                     results: data
            //                 };
            //             },
            //             cache: true
            //         }
            //     });

            //     // Update button when a customer is selected
            //     $('#customer').on('select2:select', function(e) {
            //         var data = e.params.data;

            //         // Change the text inside the button
            //         $('#customer-btn #customer-name').text(data.text);

            //         // Update binding with customer id
            //         var binding = "?customer=" + data.id;
            //         $('#customer-btn').attr('data-binding', binding);
            //     });
            // });



            var customerVAT = 0; // store selected customer's VAT

            $(document).ready(function() {
                // Initialize Select2 with AJAX search
                $('#customer').select2({
                    placeholder: 'Search Customer',
                    ajax: {
                        url: "{{ route('customers.search') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data
                            };
                        },
                        cache: true
                    }
                });

                // When a customer is selected
                $('#customer').on('select2:select', function(e) {
                    var data = e.params.data;

                    // Update button text
                    $('#customer-btn #customer-name').text(data.text);

                    // Update data-binding attribute
                    var binding = "?customer=" + data.id;
                    $('#customer-btn').attr('data-binding', binding);

                    // Store VAT from selected customer
                    customerVAT = Number(data.vat) || 0;

                    // Update VAT display
                    $('#vat_html').text(` ${customerVAT.toFixed(2)} %`);
                    alert(text(data.text));
                    // Recalculate totals
                    loadCart();
                });
            });



            // coupon


            $('#apply_coupon_btn').click(function() {
                let code = $('#coupon_code_input').val().trim();
                if (!code) return;

                $.ajax({
                    url: '/coupons/apply',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code,
                        sub_total: parseFloat($('#sub').val())
                    },
                    success: function(res) {
                        if (res.success) {
                            let type = res.coupon.type;
                            let value = parseFloat(res.coupon.value);
                            let couponDiscount = 0;

                            // Get current subtotal and manual discount
                            let sub = parseFloat($('#sub').val()) || 0;
                            let manualDiscount = parseFloat($('#discount').val()) || 0;

                            // Calculate coupon discount
                            if (type == 'fixed') {
                                couponDiscount = value;
                                $('#coupon_html').html(`Rs. ${value.toFixed(2)}`);
                            } else if (type == 'percentage') {
                                couponDiscount = (sub - manualDiscount) * value / 100;
                                $('#coupon_html').html(`${value.toFixed(2)}%`);
                            }

                            // Properly hide modal and remove backdrop
                            $('#couponModal').modal('hide');
                            $('.modal-backdrop').remove();

                            // Recalculate VAT based on net amount after discounts
                            let vatText = $('#vat_html').text().replace(/[^0-9.]/g, ''); // removes % sign
                            let vatPercent = parseFloat(vatText) || 0; // now vatPercent = 21

                            let netAmount = Math.max(0, sub - manualDiscount - couponDiscount);
                            let vatAmount = netAmount * vatPercent / 100;
                            alert(vatPercent);
                            // Calculate final total
                            let total = netAmount + vatAmount;

                            // Update display
                            $('#discount_html').html(`Rs. ${manualDiscount.toFixed(2)}`);
                            $('#total_html').html(`Rs. ${total.toFixed(2)}`);
                            $('#grand_total').text(`LKR ${total.toFixed(2)}`);
                        } else {
                            $('#coupon_error').text(res.message).show();
                        }
                    },
                    error: function(err) {
                        $('#coupon_error').text('Invalid coupon').show();
                    }
                });
            });
        </script>
        <script>
            var cart = [];

            var sub = 0;
            var total = 0;
            var vat = 0;

            function loadCart() {
                console.log('Loading cart...');
                sub = 0;
                total = 0;
                $('#loader').removeClass('d-none');
                beep();

                var symbol = "LKR";

                $('#emptyCart').hide();
                var cartItemHtml = '';

                cart.forEach((element, key) => {
                    // Ensure price is a valid number
                    var price = Number(element.price) || 0;
                    var priceFormatted = `${symbol} ${price.toLocaleString('en-US', { 
            maximumFractionDigits: 2, 
            minimumFractionDigits: 2 
        })}`;

                    sub += price * element.quantity;

                    // Add price for each modifier
                    if (element.modifiers && element.modifiers.length > 0) {
                        element.modifiers.forEach(modifier => {
                            sub += Number(modifier.price) * element.quantity;
                        });
                    }

                    cartItemHtml += `
            <div class="row p-2 align-items-center">
                <div class="col-md-4 text-center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <img loading="lazy" src="${element.image}" alt="Image of ${element.name}"
                                class="img-fluid rounded-3 card-img w-50">
                        </div>
                        <div class="col-12 mt-2">
                            <div class="row justify-content-center">
                                <div class="col-md-11">
                                    <div class="input-group input-group-sm">
                                        <button class="btn btn-dark btn-sm decrementBtn" type="button" id="decrementBtn" data-id="${key}">-</button>
                                        <input type="text" class="form-control form-control-sm text-center p-1 spinnerInput_${key}"
                                            id="spinnerInput" value="${element.quantity}" readonly>
                                        <button class="btn btn-dark btn-sm incrementBtn" type="button" id="incrementBtn"  data-id="${key}">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 mt-2 mt-md-0">
                    <div class="row align-items-center">
                        <div class="col-12 text-start">
                            <h5 class="card-title">${element.name}</h5>
                            <div class="border-bottom pb-1 mb-1">
                                <span class="price_${key}" data-price="${price}">
                                    ${priceFormatted}
                                </span>
                                <span class="quantity_${key}">x ${element.quantity}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <h4 class="total_${key}">${symbol} ${(price * element.quantity).toLocaleString('en-US', { maximumFractionDigits: 2, minimumFractionDigits: 2 })}</h4>
                                <div class="d-flex gap-2 justify-content-end align-items-center">
                                    <a href="javascript:void(0)" class="link-info fs-5" data-ajax-popup="true"
                                        data-title="Add Modifiers" data-binding="?id=${element.id}"
                                        data-url="{{ route('restaurant.modifiers') }}"><i class="bi bi-node-plus"
                                        data-bs-toggle="tooltip" title="Modify"></i></a>
                                    <a href="javascript:void(0)" class="link-danger deleteBtn" data-key="${key}"><i class="bi bi-trash3" data-bs-toggle="tooltip"
                                        title="Delete"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
                });

                $('#cartBody').html(cartItemHtml);

                if (cartItemHtml == '') {
                    $('#emptyCart').show();
                }

                // Format all currency values
                $('#sub').html(
                    `${symbol} ${sub.toLocaleString('en-US', { maximumFractionDigits: 2, minimumFractionDigits: 2 })}`);
                $('#sub').val(sub);

                // Calculate discount
                if (discount_method == 'precentage') {
                    $('#discount_method_html').html(`${discount_val}%`);
                    discount = sub * discount_val / 100;
                } else {
                    discount = parseFloat(discount_val) || 0;
                    $('#discount_method_html').html(`${symbol} ${discount_val}`);
                }

                $('#discount_html').html(
                    `${symbol} ${discount.toLocaleString('en-US', { maximumFractionDigits: 2, minimumFractionDigits: 2 })}`);

                // Extract coupon code and value
                let couponCode = $('#coupon_code_input').val().trim();
                let couponType = $('#coupon_html').text().includes('%') ? 'percentage' : 'fixed';

                // Get the coupon text and clean it
                let text = $('#coupon_html').text().trim();
                text = text.replace(/,/g, '').replace(/\u00A0/g, '');

                // Extract numeric value
                let match = text.match(/\d+(\.\d+)?/);
                let couponValue = match ? parseFloat(match[0]) : 0;

                // Calculate coupon discount
                let couponDiscount = 0;
                if (couponType === 'fixed') {
                    couponDiscount = couponValue;
                } else if (couponType === 'percentage') {
                    couponDiscount = sub * couponValue / 100;
                }

                // Calculate VAT
                if (vat_method == 'precentage') {
                    $('#vat_method_html').html(`${vat_val}%`);
                    vat = sub * vat_val / 100;
                } else {
                    vat = parseFloat(vat_val) || 0;
                    $('#vat_method_html').html(`${symbol} ${vat_val}`);
                }


                // $('#vat_html').html(
                //     `${symbol} ${vat.toLocaleString('en-US', { maximumFractionDigits: 2, minimumFractionDigits: 2 })}`);

                // Calculate total
                var vatAmount = sub * (customerVAT / 100);

                total = Math.max(0, sub - discount - couponDiscount + vatAmount);
                $('#total_html').html(
                    `${symbol} ${total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

                $('#sub').html(
                    `${symbol} ${sub.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

                $('#sub').val(sub);
                $('#total').val(total);

                // Update Grand Total in POS footer
                $('#grand_total').text(`LKR ${total.toLocaleString('en-US', { 
    minimumFractionDigits: 2, 
    maximumFractionDigits: 2 
})}`);

                // Initialize tooltips
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

                $('#loader').addClass('d-none');
            }
            $(document).ready(function() {

                $(document).on('click', '.deleteBtn', function(e) {
                    e.preventDefault();
                    $('#loader').removeClass('d-none');

                    var keyToDelete = $(this).data('key');
                    cart.splice(keyToDelete, 1);
                    $('#loader').addClass('d-none');
                    loadCart();
                });

                // Decrement function
                $(document).on('click', '.decrementBtn', function() {
                    let id = $(this).data('id');
                    let value = parseInt($(`.spinnerInput_${id}`).val());
                    if (value > 1) {
                        value--;
                        $(`.spinnerInput_${id}`).val(value);
                    }
                    cart[id]['quantity'] = value;
                    var price = cart[id]['price'];
                    loadCart()
                });

                // Increment function
                $(document).on('click', '.incrementBtn', function() {
                    let id = $(this).data('id');
                    let value = parseInt($(`.spinnerInput_${id}`).val());
                    value++;
                    $(`.spinnerInput_${id}`).val(value);
                    cart[id]['quantity'] = value;
                    var price = cart[id]['price'];
                    loadCart()
                });


            });
        </script>
        <script>
            function cancelOrder() {
                // Refresh the page
                location.reload();
            }

            function openRecentTransactions() {
                $.ajax({
                    url: "{{ route('orders.recent') }}",
                    method: "GET",
                    success: function(res) {
                        if (res.success) {
                            let container = document.getElementById('recentTransactionsTableBody');
                            container.innerHTML = ''; // clear previous rows

                            res.orders.forEach(order => {
                                let itemsHtml = order.items.map(item =>
                                    `${item.product_name}${item.variant_name ? ' (' + item.variant_name + ')' : ''} x ${item.quantity}`
                                ).join('<br>');

                                let paymentsHtml = order.payments.map(p =>
                                    `${p.payment_type} - ${Number(p.total).toFixed(2)} (${p.status})`
                                ).join('<br>');

                                container.innerHTML += `
                        <tr>
                            <td>${order.id}</td>
                            <td>${order.order_date}</td>
                            <td>${order.customer_name}</td>
                            <td>${itemsHtml}</td>
                            <td>${Number(order.total).toFixed(2)}</td>
                            <td>${paymentsHtml}</td>
                        </tr>
                    `;
                            });

                            let modal = new bootstrap.Modal(document.getElementById('recentTransactionsModal'));
                            modal.show();
                        } else {
                            alert('Failed to load transactions.');
                        }
                    },
                    error: function(err) {
                        console.error(err);
                        alert('Failed to load transactions.');
                    }
                });
            }

            const closingInput = document.getElementById('closingCash');

            closingInput.addEventListener('input', function() {
                let opening = parseFloat(document.getElementById('openingCash').value) || 0;
                let received = parseFloat(document.getElementById('totalCashReceived').value) || 0;
                let closing = parseFloat(this.value) || 0;

                let balance = closing - (opening + received);
                document.getElementById('cashBalance').value = balance.toFixed(2);
            });

            function openCashInHandModal() {
                fetch("{{ route('cash.modal') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('openingCash').value = data.data.opening_cash ?? 0;
                            document.getElementById('totalCashReceived').value = data.data.total_cash_received ?? 0;
                            document.getElementById('closingCash').value = data.data.closing_cash ?? 0;

                            // Calculate initial balance
                            updateCashBalance();

                            // Show modal
                            let modal = new bootstrap.Modal(document.getElementById('cashInHandModal'));
                            modal.show();
                        }
                    });
            }

            function updateCashBalance() {
                let opening = parseFloat(document.getElementById('openingCash').value) || 0;
                let received = parseFloat(document.getElementById('totalCashReceived').value) || 0;
                let closing = parseFloat(document.getElementById('closingCash').value) || 0;

                let balance = closing - (opening + received);
                document.getElementById('cashBalance').value = balance.toFixed(2);
            }

            function saveCashInHand() {
                let opening = parseFloat(document.getElementById('openingCash').value) || 0;
                let closing = parseFloat(document.getElementById('closingCash').value) || 0;

                fetch("{{ route('cash.save') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            opening_cash: opening,
                            closing_cash: closing
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        // Update the fields with the returned balance
                        document.getElementById('cashBalance').value = (data.balance ?? 0).toFixed(2);

                        alert(data.message + "\nBalance: " + (data.balance ?? 0).toFixed(2));

                        let modal = bootstrap.Modal.getInstance(document.getElementById('cashInHandModal'));
                        modal.hide();
                    })
                    .catch(err => console.error(err));
            }
        </script>

        <script>
            function checkout() {
                beep(); // optional sound
                $('#loader').removeClass('d-none');

                if (cart.length === 0) {
                    display_error('Add one or more items to the cart');
                    $('#loader').addClass('d-none');
                    return;
                }


                var totalBill = document.getElementById("totalBillHidden").value;
                var received = document.getElementById("cashReceivedHidden").value;
                var balance = document.getElementById("cashBalanceHidden").value;
                var depositrecipt = document.getElementById("depositReceiptHidden").value;
                ptype = document.getElementById("paymentTypeHidden").value;

                const formData = new FormData();
                formData.append('customer', customer);
                formData.append('sub', sub);
                formData.append('discount', discount);
                formData.append('vat', customerVAT);
                formData.append('total', total);

                formData.append('total_bill', totalBill);
                formData.append('cash_received', received);
                formData.append('cash_balance', balance);
                formData.append('ptype', ptype);
                formData.append('dr', depositrecipt);

                formData.append('payment_note', payment_note);
                formData.append('type', $('#type').val());

                // Prepare cart items for backend
                const stockCart = cart.map(item => ({
                    product_id: item.pid,
                    variant_id: item.vid || null,
                    inventory_id: item.inventory_id,
                    price: item.price,
                    quantity: item.quantity,
                    vat: item.vat || 0
                }));


                // Assume you already have coupon code and type/value calculated
                let couponCode = $('#coupon_code_input').val().trim();
                let couponType = $('#coupon_html').text().includes('%') ? 'percentage' : 'fixed';

                // Get the coupon text
                let text = $('#coupon_html').text().trim();

                // Replace commas and non-breaking spaces
                text = text.replace(/,/g, '').replace(/\u00A0/g, '');

                // Extract first numeric value (digits + optional decimal)
                let match = text.match(/\d+(\.\d+)?/);

                // Convert to number, default to 0 if not found
                couponValue = match ? parseFloat(match[0]) : 0;

                // console.log(couponValue); // Should be 100 for "100 Rs." or 10 for "10%"



                // Append coupon details to formData
                formData.append('coupon_code', couponCode);
                formData.append('coupon_type', couponType);
                formData.append('coupon_value', couponValue);
                formData.append('cart', JSON.stringify(stockCart));

                $.ajax({
                    type: 'POST',
                    url: "{{ route('restaurant.checkout') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function(response) {
                        $('#loader').addClass('d-none');
                        if (response.success) {
                            display_success(response.message);
                            if (response.url) {
                                window.open(response.url, '_blank');
                            }
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            display_error(response.message);
                        }
                    },
                    error: function(xhr) {
                        $('#loader').addClass('d-none');
                        const errorMessage = xhr.status + ': ' + xhr.statusText;
                        display_error(errorMessage);
                    }
                });
            }
      
      </script>

        <script>
            var previouslyClickedItem = null;

            function highlightCategoryItem(item) {
                // Check if there's a previously clicked item
                if (previouslyClickedItem && previouslyClickedItem !== item) {
                    // Reset styles of the previously clicked item
                    previouslyClickedItem.style.color = 'black';
                    previouslyClickedItem.style.backgroundColor = '#F5F5F5';
                }

                // Apply styles to the clicked item
                item.style.color = 'white';
                item.style.backgroundColor = '#318CE7';

                // Update the previously clicked item to the current item
                previouslyClickedItem = item;


            }
        </script>



        <script>
            // Function to handle category item click
            function handleCategoryItemClick(item) {
                var itemName = $(item).find('.category-name').text().trim();


                $('#mealTypeSelector').hide();
                $('#setmenuTypeSelector').hide();
                $('#setmenusearch').hide();


                if (itemName === 'Setmenu') {

                    $('#mealTypeSelector').show();
                    $('#setmenuTypeSelector').show();
                    $('#setmenusearch').show();
                }

            }

            // Example of existing click handler for category items
            $(document).ready(function() {
                $('.category-item').click(function() {
                    handleCategoryItemClick(this);


                });
            });

            function filter() {
                var mealTypeSelect = document.getElementById('setmenuMealType');
                var selectedMeal = mealTypeSelect.value;

                var typeSelect = document.getElementById('setmenuType');
                var selectedType = typeSelect.value;
                var itemsFound = false;

                if (selectedMeal === '' && selectedType === '') {
                    $('#noResultsMessage').hide();
                    return;
                }

                $('.meal-item').each(function() {
                    var itemMealType = $(this).data('mealtype');
                    var itemType = $(this).data('type');

                    if ((selectedMeal === '' || itemMealType == selectedMeal) &&
                        (selectedType === '' || itemType == selectedType)) {
                        $(this).show();
                        itemsFound = true;
                    } else {
                        $(this).hide();
                    }
                });
                if (!itemsFound) {
                    $('#noResultsMessage').show();
                } else {
                    $('#noResultsMessage').hide();
                }
            }
        </script>
    @endsection
