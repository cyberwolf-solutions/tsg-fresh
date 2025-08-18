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
            color: #858282;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #858282;
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
            background-color: #ffffff;
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
            margin-left: 130px;
            padding-left: 15px;
            padding-right: 1px;
            max-width: 100%;
        }

        @media (min-width: 992px) {
            .centered-wrapper {
                max-width: calc(100% - 250px);
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

        .product-info {
            display: flex;
            align-items: flex-start;
            gap: 20px;
        }

        .social-media {
            display: flex;
            gap: 10px;
        }

        .social-icon {
            color: #666;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-icon:hover {
            color: #007bff;
            /* Blue color on hover */
        }

        .fab,
        .far {
            font-family: "Font Awesome 5 Free";
        }

        .carousel {
            margin: 20px 0;
            padding: 10px;
        }

        .carousel-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        .carousel-slide {
            display: flex;
            overflow: hidden;
            transition: transform 0.5s ease;
        }

        .carousel-item {
            min-width: 150px;
            height: 200px;
            margin: 0 10px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .carousel-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
            padding: 0 10px;
            z-index: 1;
        }

        .carousel-btn:hover {
            color: #000;
        }

        .prev {
            margin-right: 10px;
        }

        .next {
            margin-left: 10px;
        }

        /* Adjust to show 4 items at a time */
        .carousel-slide {
            width: calc(150px * 4 + 30px * 3);
            /* 4 items width + 3 gaps */
            transform: translateX(0);
        }

        @media (min-width: 600px) {
            .carousel-slide {
                width: 100%;
                /* Allow flexible width on larger screens */
            }
        }

        .product-image-wrapper:hover .product-image {
            transform: scale(1.1);
            /* zooms 10% */
        }
    </style>
    <style>
        .carousel {
            width: 100%;
            overflow: hidden;
        }

        .carousel-container {
            display: flex;
            align-items: center;
            position: relative;
        }

        .carousel-slide {
            display: flex;
            overflow-x: hidden;
            /* hide scrollbar */
            scroll-behavior: smooth;
            gap: 20px;
            width: 100%;
        }

        .carousel-item {
            flex: 0 0 200px;
            height: 250px;
            position: relative;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 6px;
            overflow: hidden;
            background: #fff;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* ensures image fills nicely */
            display: block;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: rgb(0, 0, 0);
            font-size: 20px;
            background: rgba(231, 226, 226, 0.863);
            padding: 5px 10px;
            border-radius: 4px;
            white-space: nowrap;
            width: 100%;
            height: 50px
        }

        .carousel-btn {
            background: #fffefe;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 50%;
            z-index: 10;
        }

        .carousel-btn:hover {
            background: #ffffff;
        }
    </style>


    <div class="centered-wrapper  col-12">
        <!-- Main Content -->
        <div class="container mb-5 " style="margin-top: 170px;">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb mt-5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-secondary" style="font-size: large"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active text-secondary" aria-current="page" style="font-size: large">Fish</li>
                </ol>
            </nav>

            <div class="row mt-4  ">
                <!-- Sidebar -->

                <!-- Products -->
                <div class="col-lg-9">
                    <div class="row">
                        <!-- Left Column: Product Image -->
                        <div class="col-md-8" style="text-align: center; margin-right: 0px;">

                            @if ($product->image_url)
                                <div class="product-image-wrapper"
                                    style="overflow: hidden;  width: 500px; height: 500px; border-radius: 0;">
                                    <img src="{{ asset('uploads/products/' . $product->image_url) }}"
                                        alt="{{ $product->name }}" class="product-image"
                                        style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;">
                                </div>
                            @endif


                            {{-- <img src="https://images.pexels.com/photos/128420/pexels-photo-128420.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Product Image" style="width: 100%; max-width: 100%; border-radius: 8px;">
                        --}}
                        </div>

                        <!-- Right Column: Product Details -->
                        <div class="col-md-3" style="padding-top: 10px;">
                            <!-- Name -->
                            <h3 class="mb-3" style="text-transform: uppercase; font-weight: bold; color: #4e4d4d;">
                                {{ $product->name }}</h3>

                            <hr class="mt-2 mb-4 bold" style="width:30px">

                            <!-- Price -->
                            <p class="mb-4" style="font-size: 1rem; margin-bottom: 10px; color: #4e4d4d;">
                                <span style="color: #000; font-size: 20px;">රු</span>
                                <span style="color: #000; font-size: 20px;" class="fw-bold">
                                    {{ number_format($product->final_price ?? $product->product_price, 2) }}</span>
                            </p>





                            <!-- Variant Selector -->
                            @if ($product->variants->count() > 0)
                                <div class="mb-4" style="margin-bottom: 15px;">
                                    <select id="priceOption" class="form-control" onchange="updatePrice()"
                                        style="font-size: 0.95rem;">
                                        @foreach ($product->variants as $variant)
                                            <option value="{{ $variant->variant_price }}">
                                                {{ $variant->variant_name }} - Rs
                                                {{ number_format($variant->variant_price, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <p>
                                <strong></strong>
                                <span id="productPrice">
                                    {{ $product->name }}
                                </span>
                            </p>


                            <p>
                                <strong></strong>
                                <span id="productPrice" class="mt-3">
                                    {{ $product->name }} 1 KG
                                </span>
                            </p>

                            <div class="d-flex align-items-center mb-3 mt-4">
                                <label for="typeSize" class="me-2 small text-dark"
                                    style="white-space: nowrap;">Type-Size</label>
                                <select class="form-select w-auto small text-secondary" id="typeSize"
                                    aria-label="Choose an option" style="font-size: small;">
                                    <option selected disabled>Choose an option</option>
                                    <option value="small">Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                                </select>
                            </div>



                            <!-- Quantity Selector -->
                            <div class="d-flex align-items-center gap-2 mt-3 mb-4">
                                <button type="button" onclick="changeQty(-1)"
                                    style="width: 30px; height: 30px; border: 1px solid #ccc; background: #fff; cursor: pointer; border-radius: 0;">-</button>

                                <input id="quantity" type="text" value="1" readonly
                                    style="width: 40px; height: 30px; text-align: center; border: 1px solid #ccc; background: #fff; border-radius: 0;">

                                <button type="button" onclick="changeQty(1)"
                                    style="width: 30px; height: 30px; border: 1px solid #ccc; background: #fff; cursor: pointer; border-radius: 0;">+</button>

                                <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                                    aria-controls="offcanvasExample"
                                    style="background-color: #007bff; color: white; border: none; padding: 5px 15px; font-size: 14px; cursor: pointer; border-radius: 5px; white-space: nowrap;">
                                    ADD TO CART
                                </button>
                            </div>


                            <!-- Add to Cart Button -->


                            <!-- SKU and Category -->
                            <p class="mt-3"style="font-size: 0.9rem; color: #666; margin-bottom: 5px;">SKU: <span
                                    style="color: #000;">{{ $product->sku ?? 'HURULLA-500KG' }}</span></p>
                            <p class="mt-4" style="font-size: 0.9rem; color: #666;">Category: <span
                                    style="color: #000;">{{ $product->categories->pluck('name')->implode('/') ?? 'FISH' }}</span>
                            </p>
                            <div class="social-media">
                                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon"><i class="far fa-envelope"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-pinterest"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
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
                                    data-bs-target="#additional" type="button" role="tab"
                                    aria-controls="additional" aria-selected="true" style="border: none;">
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
                                        <td style="font-weight: bold; color: #555; padding: 10px;">TYPE-PRICE</td>
                                        <td style="padding: 10px;">
                                            {!! nl2br(e($product->description)) !!}
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

        <div class="carousel col-md-12" style="border-top: 2px solid #eaecee;">

            <h4 style="color: #666;">RELATED PRODUCTS</h4>
            <div class="carousel-container mt-4">
                <button class="carousel-btn prev">&lt;</button>
                <div class="carousel-slide">
                    <div class="carousel-item">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Giant Freshwater Shrimp">
                        <div class="overlay">OUT OF STOCK</div>
                        {{-- <p>Giant Freshwater Shrimp<br>₴2,500.00</p> --}}
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Prawn Bites">
                        <div class="overlay">OUT OF STOCK</div>
                        {{-- <p>Prawn Bites<br>₴1,639.70</p> --}}
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Kochi Prawn Bites">
                        <div class="overlay">OUT OF STOCK</div>
                        {{-- <p>Kochi Prawn Bites<br>₴861.32</p> --}}
                    </div>
                    <div class="carousel-item">
                        <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Whole Prawns Jumbo-Headless">
                        {{-- <p>Whole Prawns Jumbo-Headless<br>₴3,900.00</p> --}}
                    </div>
                </div>
                <button class="carousel-btn next">&gt;</button>
            </div>
        </div>

    </div>
    <footer class="footer ml-4 d-flex" style="border-top: 2px solid #eaecee;">
        <div class="container d-flex">
            <div class="row" style="margin-left: 60px; margin-right: 60px;">
                <!-- Latest Products -->
                <div class="col-md-4 ml-4">
                    <div class="footer-widget">
                        <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">LATEST</h5>
                        <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                            class="mb-4">


                        <div class="footer-product mt-2"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Best Selling -->
                <div class="col-md-4 ml-4">
                    <div class="footer-widget">
                        <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">BEST SELLING
                        </h5>
                        <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                            class="mb-4">


                        <div class="footer-product mt-2"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Rated -->
                <div class="col-md-4 ml-4">
                    <div class="footer-widget">
                        <h5 style="text-transform: uppercase; margin-bottom: 5px;" class="text-secondary">TOP RATED
                        </h5>
                        <hr style="border: 0.3px solid currentColor; opacity: 0.4; margin-top: 0; width: 30px;"
                            class="mb-4">


                        <div class="footer-product mt-2"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                        <div class="footer-product mt-4"
                            style="display: flex; align-items: flex-start; margin-bottom: 15px;">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                alt="Clean Jumbo Prawns"
                                style="width: 50px; height: 50px; margin-right: 10px; object-fit: cover;">
                            <div class="footer-product-info" style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0; font-size: 16px;" class="text-secondary">Clean Jumbo
                                    Prawns
                                    500g</h6>
                                <p class="price text-dark" style="margin: 0; font-size: 16px;">රු 2,450.00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    {{-- OFFCNAVAS CART --}}

    @include('landing-page.partials.cart')

    <!-- Footer -->

    <script>
        const slide = document.querySelector('.carousel-slide');
        const prevBtn = document.querySelector('.prev');
        const nextBtn = document.querySelector('.next');
        let scrollAmount = 0;

        prevBtn.addEventListener('click', () => {
            slide.scrollLeft -= 220;
        });
        nextBtn.addEventListener('click', () => {
            slide.scrollLeft += 220;
        });

        // Auto loop
        setInterval(() => {
            if (slide.scrollLeft + slide.clientWidth >= slide.scrollWidth) {
                slide.scrollLeft = 0;
            } else {
                slide.scrollLeft += 220;
            }
        }, 3000); // every 3 seconds
    </script>

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
    <script>
        function updatePrice() {
            let selectedPrice = document.getElementById("priceOption").value;
            let priceDisplay = document.getElementById("productPrice");

            if (priceDisplay) {
                priceDisplay.textContent = "Rs " + Number(selectedPrice).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }
    </script>
    <script>
        const slide = document.querySelector('.carousel-slide');
        const items = document.querySelectorAll('.carousel-item');
        let currentIndex = 0;
        const itemsPerPage = 4;
        const itemWidth = 150; // Width of each item
        const gap = 10; // Gap between items

        function updateSlide() {
            const offset = -(currentIndex * (itemWidth + gap * 2));
            slide.style.transform = `translateX(${offset}px)`;
        }

        document.querySelector('.next').addEventListener('click', () => {
            if (currentIndex < items.length - itemsPerPage) {
                currentIndex++;
                updateSlide();
            }
        });

        document.querySelector('.prev').addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlide();
            }
        });
    </script>

@endsection
