@extends('landing-page.layouts.app')

@section('content')
    <style>
        /* Main Styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: #606060;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://tsg-fresh.com/wp-content/uploads/2023/06/Untitled-1-1.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            color: white;
            text-align: center;
            margin-bottom: 30px;
        }

        .hero-banner h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .breadcrumb-item a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #333;
        }

        /* Product Grid */
        .product-card {
            border: none;
            border-radius: 0;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            position: relative;
            background: #fff;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-card .card-img-top {
            border-radius: 0;
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .product-card .card-body {
            padding: 15px;
            text-align: center;
        }

        .product-card .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .product-card .price {
            color: #d9232d;
            font-weight: 600;
            margin-bottom: 0;
        }

        .out-of-stock {
            color: #d9232d;
            font-weight: 600;
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 0;
        }

        /* Sidebar */
        .sidebar-widget {
            margin-bottom: 30px;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .sidebar-widget h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            color: #333;
        }

        .sidebar-widget ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-widget ul li {
            margin-bottom: 10px;
        }

        .sidebar-widget ul li a {
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            padding: 5px 0;
        }

        .sidebar-widget ul li a:hover {
            color: #d9232d;
            padding-left: 5px;
        }

        /* Price Filter */
        .price-slider {
            width: 100%;
            -webkit-appearance: none;
            height: 5px;
            background: #ddd;
            outline: none;
            margin-top: 15px;
        }

        .price-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 15px;
            height: 15px;
            background: #d9232d;
            cursor: pointer;
            border-radius: 50%;
        }

        .price-range {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }

        .btn-filter {
            background-color: #333;
            color: white;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            margin-top: 15px;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            background-color: #d9232d;
        }

        /* Sorting */
        .sorting-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .sorting-options .form-select {
            width: auto;
            border-radius: 0;
            border: 1px solid #ddd;
            padding: 8px 15px;
            font-size: 14px;
        }

        /* Footer */
        .footer {
            background-color: #f8f9fa;
            padding: 60px 0 30px;
            margin-top: 50px;
        }

        .footer-widget {
            margin-bottom: 30px;
        }

        .footer-widget h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .footer-product {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .footer-product img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            margin-right: 15px;
        }

        .footer-product-info h6 {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
            color: #333;
            line-height: 1.3;
        }

        .footer-product-info .price {
            color: #d9232d;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 0;
        }

        .footer-product-info .rating {
            color: #ffc107;
            font-size: 12px;
            margin: 3px 0;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-banner h1 {
                font-size: 36px;
            }
        }

        @media (max-width: 767px) {
            .hero-banner {
                padding: 60px 0;
            }

            .hero-banner h1 {
                font-size: 28px;
            }

            .sorting-options {
                flex-direction: column;
                align-items: flex-start;
            }

            .sorting-options .form-select {
                margin-top: 10px;
                width: 100%;
            }
        }

        .centered-wrapper {
            margin: 0 auto;
            padding-left: 15px;
            padding-right: 15px;
            max-width: 100%;
        }

        @media (min-width: 992px) {
            .centered-wrapper {
                max-width: calc(100% - 400px);
                /* 200px left & right */
                padding-left: 0;
                padding-right: 0;
            }
        }

        .nav-tabs .nav-link {
            color: #333;
            border: none;
            position: relative;
            font-weight: 500;
        }

        .nav-tabs .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #007bff;
            transition: width 0.3s ease-in-out;
        }



        .custom-outline-blue {
            border: 1px solid #007bff;
            /* Bootstrap blue */
            color: #000;
            /* Black text */
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .custom-outline-blue:hover {
            background-color: #007bff;
            /* Blue background */
            color: #fff;
            /* White text */
            border-color: #007bff;
        }
    </style>
    <!-- Hero Banner -->





    <div class="container my-5" style="margin-top: 120px;">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" style="margin-top: 120px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">SHOPPING CART</li>
                <li class="breadcrumb-item">CHECKOUT DETAILS</li>
                <li class="breadcrumb-item active" aria-current="page">ORDER COMPLETE</li>
            </ol>
        </nav>

        <!-- Info Bar -->
        <div class="text-center mb-3 text-muted" style="font-size: 14px;">
            IF YOU EXPERIENCE ANY ISSUES DURING CHECKOUT PLEASE CALL HOTLINE +94774000010
        </div>

        <!-- Login and Coupon -->
        <div class="text-start mb-4">
            <p>Returning customer? <a href="#">Click here to login</a></p>
            <p>Have a coupon? <a href="#">Click here to enter your code</a></p>
        </div>

        <hr class="custom-grey-hr" style=" border-color: #ccc; width:60%;
    opacity: 1; ">


        <!-- Checkout Grid -->
        <div class="row mt-5">
            <!-- Billing & Shipping -->
            <div class="col-md-7">
                <h5>BILLING & SHIPPING</h5>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">First name *</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Last name (optional)</label>
                            <input type="text" class="form-control">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Street address *</label>
                        <input type="text" class="form-control mb-2" placeholder="House number and street name">
                        <input type="text" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Town / City *</label>
                        <select class="form-select">
                            <option>Colombo 2</option>
                            <option>Colombo 3</option>
                            <option>Colombo 4</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="tel" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email address *</label>
                        <input type="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Create account password *</label>
                        <input type="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order notes (optional)</label>
                        <textarea class="form-control" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-md-5">
                <div class="card border-primary">
                    <div class="card-body">
                        <h5 class="card-title">YOUR ORDER</h5>

                        <div class="d-flex justify-content-between">
                            <strong>PRODUCT</strong>
                            <strong>SUBTOTAL</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>CLEAN PRAWNS 1KG × 1</span>
                            <span>₨3,725.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span>₨3,725.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Shipping</span>
                            <span>₨750.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span>₨4,475.00</span>
                        </div>
                        <small class="text-muted">(includes ₨568.22 VAT 18%)</small>

                        <hr>

                        <!-- Delivery Date -->
                        <div class="mb-3">
                            <label class="form-label">Delivery Date *</label>
                            <input type="date" class="form-control" value="2025-07-30">
                            <small class="text-muted">We will try our best to deliver your order on the specified
                                date.</small>
                        </div>

                        <!-- Payment Methods -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="payment" checked>
                                <label class="form-check-label">Direct bank transfer</label>
                                <small class="d-block text-muted ms-4">
                                    Make your payment directly into our bank account. Please use your Order ID as the
                                    payment reference.
                                </small>
                            </div>
                            <div class="form-check mt-2">
                                <input type="radio" class="form-check-input" name="payment">
                                <label class="form-check-label">Cash on Delivery - COD</label>
                            </div>
                            <div class="form-check mt-2">
                                <input type="radio" class="form-check-input" name="payment">
                                <label class="form-check-label">Online Payment</label>
                                <div class="mt-2 ms-4">
                                    <img src="https://www.payhere.lk/downloads/images/payhere_long_banner.png"
                                        alt="PayHere" style="max-width: 100%;">
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button class="btn custom-outline-blue w-100">PLACE ORDER</button>

                        <p class="mt-3 text-muted small">
                            Your personal data will be used to process your order, support your experience throughout this
                            website, and for other purposes described in our <a href="#">privacy policy</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Latest Products -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h5>Latest</h5>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns">
                            <div class="footer-product-info">
                                <h6>Clean Jumbo Prawns 500g</h6>
                                <p class="price">Rs 2,450.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Squid">
                            <div class="footer-product-info">
                                <h6>Squid</h6>
                                <p class="price">From: Rs 1,525.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Kochi Bites 500g">
                            <div class="footer-product-info">
                                <h6>Kochi Bites 500g</h6>
                                <p class="price">Rs 2,530.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Kochi Bites 240g">
                            <div class="footer-product-info">
                                <h6>Kochi Bites 240g</h6>
                                <p class="price">Rs 1,330.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Best Selling -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h5>Best Selling</h5>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Prawns 1kg">
                            <div class="footer-product-info">
                                <h6>Clean Prawns 1kg</h6>
                                <p class="price">From: Rs 3,400.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Crab Meat">
                            <div class="footer-product-info">
                                <h6>Crab Meat</h6>
                                <p class="price">From: Rs 2,360.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Seer Fish">
                            <div class="footer-product-info">
                                <h6>Seer Fish</h6>
                                <p class="price">From: Rs 750.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Whole Prawns">
                            <div class="footer-product-info">
                                <h6>Whole Prawns</h6>
                                <p class="price">From: Rs 2,065.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Rated -->
                <div class="col-md-4">
                    <div class="footer-widget">
                        <h5>Top Rated</h5>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Handella (Anchovies) 500g">
                            <div class="footer-product-info">
                                <h6>Handella (Anchovies) 500g</h6>
                                <p class="rating">★★★★★</p>
                                <p class="price">Rs 1,121.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Pak Choi & Mushroom Dumplings">
                            <div class="footer-product-info">
                                <h6>Pak Choi & Mushroom Dumplings [10 Pieces]</h6>
                                <p class="rating">★★★★★</p>
                                <p class="price">Rs 1,500.00</p>
                            </div>
                        </div>

                        <div class="footer-product">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Atlantic Cod Steak 500g">
                            <div class="footer-product-info">
                                <h6>Atlantic Cod Steak (500g)</h6>
                                <p class="rating">★★★★★</p>
                                <p class="price">Rs 1,475.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
