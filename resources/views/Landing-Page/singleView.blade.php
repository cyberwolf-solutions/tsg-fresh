@extends('landing-page.layouts.app')

@section('content')
    <style>
        /* Main Styles */
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
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

        .offcanvas {
            z-index: 10050 !important;
            /* higher than your header */
            background-color: white !important;
            color: black;
        }

        x .offcanvas-backdrop {
            background-color: transparent !important;
        }
    </style>

    <!-- Hero Banner -->
    <div class="hero-banner d-none">
        <div class="container">
            <h1>Shop</h1>
        </div>
    </div>

    <div class="centered-wrapper">
        <!-- Main Content -->
        <div class="container mb-5 " style="margin-top: 120px;">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>

            <div class="row mt-4">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    <!-- Categories Widget -->
                    <div class="sidebar-widget" style="color: blue">
                        <h4>BROWSE</h4>
                        <ul style="color: blue">
                            <li style="color: blue"><a href="#">Crab</a></li>
                            <li><a href="#">Dumplings</a></li>
                            <li><a href="#">Fish</a></li>
                            <li><a href="#">Imported Seafood</a></li>
                            <li><a href="#">Prawn Bites</a></li>
                            <li><a href="#">Prawns/Shrimps</a></li>
                            <li><a href="#">Squid</a></li>
                        </ul>
                    </div>




                    <!-- Image Banner Widget -->
                    <div class="sidebar-widget p-0 border-0" style="box-shadow:none;">
                        <img src="{{ asset('build/images/image.png') }}" class="img-fluid" alt="Promotional Banner">
                    </div>

                </div>

                <!-- Products -->
                <div class="col-lg-9">
                    <div class="row">
                        <!-- Left Column: Product Image -->
                        <div class="col-md-8" style="text-align: center;">
                            <img src="https://images.pexels.com/photos/128420/pexels-photo-128420.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Product Image" style="width: 100%; max-width: 100%; border-radius: 8px;">
                        </div>

                        <!-- Right Column: Product Details -->
                        <div class="col-md-4" style="padding-top: 10px;">
                            <!-- Name -->
                            <h3 class="mb-4" style="text-transform: uppercase; font-weight: bold; color: black;">
                                Prawns/Shrimps</h3>

                            <!-- Short grey line -->
                            <hr class="mb-4" style="border-top: 2px solid lightgray; width: 40px; margin: 10px 0;">

                            <!-- Price -->
                            <p class="mb-4" style="font-size: 1rem; margin-bottom: 10px;">
                                <span style="color: gray;">From:</span>
                                <span style="color: black;">Rs 2,000</span>
                            </p>

                            <!-- Dropdown -->
                            <div class="mb-4" style="margin-bottom: 15px;">
                                <select id="priceOption" class="form-control" onchange="updatePrice()"
                                    style="font-size: 0.95rem;">
                                    <option value="2000">Small - Rs 2,000</option>
                                    <option value="3000">Medium - Rs 3,000</option>
                                    <option value="4000">Large - Rs 4,000</option>
                                </select>
                            </div>

                            <!-- Dynamic Price Update -->
                            <div class="mb-4" id="updatedPrice" style="font-size: 1rem; margin-bottom: 15px;">
                                <span style="color: gray;">Selected:</span>
                                <span id="priceDisplay" style="color: black;">Rs 2,000</span>
                            </div>

                            <!-- Quantity Selector -->
                            <div class="mb-4" style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                <label for="quantity" style="margin-bottom: 0;">Qty:</label>
                                <button type="button" onclick="changeQty(-1)" style="width: 30px; height: 30px;">-</button>
                                <input id="quantity" type="text" value="1" readonly
                                    style="width: 40px; text-align: center;">
                                <button type="button" onclick="changeQty(1)" style="width: 30px; height: 30px;">+</button>
                            </div>

                            <!-- Add to Cart Button -->
                            <button class="mb-4" class="btn" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"
                                style="background-color: #58a6f9; color: white; width: 100%; margin-bottom: 20px;border-style:none">
                                Add to Cart
                            </button>

                            <!-- Grey line -->
                            <hr style="border-top: 1px solid #ccc;">

                            <!-- SKU and Category -->
                            <p style="font-size: 0.9rem; color: gray; margin-bottom: 5px;">SKU: <span
                                    style="color: black;">N/A</span></p>
                            <p style="font-size: 0.9rem; color: gray;">Category: <span style="color: black;">Seafood</span>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- REVIEWS --}}
            <div class="row mt-5 mb-5">
                <div class="col-12">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="productTab" role="tablist" style="border-bottom: 1px solid #ddd;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="additional-tab" data-bs-toggle="tab"
                                data-bs-target="#additional" type="button" role="tab" aria-controls="additional"
                                aria-selected="true" style="border: none;">
                                ADDITIONAL INFORMATION
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews" aria-selected="false"
                                style="border: none;">
                                REVIEWS (0)
                            </button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="productTabContent" style="padding-top: 20px;">
                        <!-- Additional Info Tab -->
                        <div class="tab-pane fade show active" id="additional" role="tabpanel"
                            aria-labelledby="additional-tab">
                            <table style="width: 100%; font-size: 0.95rem;">
                                <tr style="border-top: 1px solid #eee;">
                                    <td style="font-weight: bold; color: #555; padding: 10px;">WEIGHT</td>
                                    <td style="padding: 10px;">1 kg</td>
                                </tr>
                                <tr style="border-top: 1px solid #eee;">
                                    <td style="font-weight: bold; color: #555; padding: 10px;">CLEAN PRAWNS</td>
                                    <td style="padding: 10px;">
                                        Clean Prawns Large 16/20, Clean Prawns Medium 26/30, Clean Prawns Medium 31/40,
                                        Clean Prawns Small 41/50
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Reviews Tab -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <h5 style="font-weight: bold;">Reviews</h5>
                            <p>There are no reviews yet.</p>
                            <div class="mt-3" style="border: 2px solid #007bff; padding: 20px; color: gray;">
                                Only logged in customers who have purchased this product may leave a review.
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    {{-- OFFCNAVAS CART --}}

    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 id="cartSidebarLabel" style="font-weight: 700; margin: 0 auto;">CART</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column justify-content-between p-3" style="padding-bottom: 0;">

            <!-- Cart Items -->
            <div>
                <div class="d-flex mb-3">
                    <!-- Image -->
                    <img src="{{ asset('build/images/landing/l1.png') }}" alt="Product"
                        style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">

                    <!-- Product Info -->
                    <div class="ms-3 flex-grow-1">
                        <div style="font-weight: bold; color: #0056b3;">CLEAN PRAWNS 1KG -</div>
                        <div style="color: #0056b3;">Clean Prawns Large 16/20</div>
                        <div style="font-size: 14px; margin-top: 5px; color: gray;">
                            2 × <span style="color: black; font-weight: 600;">Rs 4,150.00</span>
                        </div>
                    </div>

                    <!-- Remove Button -->
                    <button class="btn  p-0 ms-2" style="color: gray;background:white">
                        <i class="fas fa-times-circle" style="font-size: 20px;"></i>
                    </button>
                </div>
            </div>

            <!-- Footer -->
            <div>
                <hr>
                <div class="d-flex justify-content-between mb-2" style="font-weight: 600;">
                    <span style="color: gray;">Subtotal:</span>
                    <span style="color: black;">Rs 8,300.00</span>
                </div>

                <button class="btn w-100"
                    style="background-color: #1261a0; color: white; font-weight: 600; margin-bottom: 10px;">
                    VIEW CART
                </button>

                <button class="btn w-100" style="background-color: #4ea7f8; color: white; font-weight: 600;">
                    CHECKOUT
                </button>
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

    <script>
        function updatePrice() {
            const select = document.getElementById("priceOption");
            const selectedPrice = select.options[select.selectedIndex].value;
            document.getElementById("priceDisplay").innerText = `Rs ${selectedPrice}`;
        }

        function changeQty(delta) {
            const qtyInput = document.getElementById("quantity");
            let current = parseInt(qtyInput.value);
            if (current + delta >= 1) {
                qtyInput.value = current + delta;
            }
        }
    </script>
@endsection
