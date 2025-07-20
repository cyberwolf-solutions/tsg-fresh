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
    </style>

    <!-- Hero Banner -->
    <div class="hero-banner d-none">
        <div class="container">
            <h1>Shop</h1>
        </div>
    </div>

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
                <div class="sidebar-widget">
                    <h4>BROWSE</h4>
                    <ul>
                        <li><a href="#">Crab</a></li>
                        <li><a href="#">Dumplings</a></li>
                        <li><a href="#">Fish</a></li>
                        <li><a href="#">Imported Seafood</a></li>
                        <li><a href="#">Prawn Bites</a></li>
                        <li><a href="#">Prawns/Shrimps</a></li>
                        <li><a href="#">Squid</a></li>
                    </ul>
                </div>

                <!-- Price Filter Widget -->
                <div class="sidebar-widget">
                    <h4>Filter by price</h4>
                    <input type="range" class="price-slider" min="0" max="5115" value="5115">
                    <div class="price-range">
                        <span>Price: Rs 0</span>
                        <span>Rs 5,115</span>
                    </div>
                    <button class="btn btn-filter">Filter</button>
                </div>

                <!-- Recently Viewed Widget -->
                <div class="sidebar-widget">
                    <h4>Recently Viewed</h4>
                    <div class="footer-product">
                        <img src="https://images.pexels.com/photos/128408/pexels-photo-128408.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Lobster">
                        <div class="footer-product-info">
                            <h6>Lobster</h6>
                            <p class="price">From: Rs 4,500.00</p>
                        </div>
                    </div>
                    <div class="footer-product">
                        <img src="https://images.pexels.com/photos/3296277/pexels-photo-3296277.jpeg?auto=compress&cs=tinysrgb&w=800"
                            alt="Salmon Fillet">
                        <div class="footer-product-info">
                            <h6>Salmon Fillet</h6>
                            <p class="price">From: Rs 2,250.00</p>
                        </div>
                    </div>
                </div>

                <!-- Image Banner Widget -->
                <div class="sidebar-widget p-0 border-0" style="box-shadow:none;">
                    <img src="{{ asset('build/images/image.png') }}" class="img-fluid" alt="Promotional Banner">
                </div>

            </div>

            <!-- Products -->
            <div class="col-lg-9">
                <!-- Sorting Options -->
                <div class="sorting-options">
                    <p class="mb-0">Showing all 45 results</p>
                    <select class="form-select">
                        <option>Default sorting</option>
                        <option>Sort by popularity</option>
                        <option>Sort by average rating</option>
                        <option>Sort by latest</option>
                        <option>Sort by price: low to high</option>
                        <option>Sort by price: high to low</option>
                    </select>
                </div>

                <!-- Product Grid -->
                <div class="row">
                    <!-- Product 1 -->
                    <!-- Product 1 - Prawns/Shrimps -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/128420/pexels-photo-128420.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Prawns/Shrimps">
                            <div class="card-body">
                                <h5 class="card-title">Prawns/Shrimps</h5>
                                <p class="price">Clean: Rs 3,400.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 - Crab Meat -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Tuna Steak">
                            <div class="card-body">
                                <h5 class="card-title">Crab Meat</h5>
                                <p class="price">From: Rs 2,360.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 - Seer Fish -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Tuna Steak">
                            <div class="card-body">
                                <h5 class="card-title">Seer Fish</h5>
                                <p class="price">From: Rs 750.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 - Whole Prawns -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/1031147/pexels-photo-1031147.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Whole Prawns">
                            <div class="card-body">
                                <h5 class="card-title">Prawns/Shrimps</h5>
                                <p class="price">Whole: Rs 2,065.00</p>
                                <p class="out-of-stock text-danger">Out of Stock</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 5 - Prawn Bites -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Tuna Steak">
                            <div class="card-body">
                                <h5 class="card-title">Prawn Bites</h5>
                                <p class="price">From: Rs 1,330.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 6 - Squid -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/4067695/pexels-photo-4067695.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Squid">
                            <div class="card-body">
                                <h5 class="card-title">Squid</h5>
                                <p class="price">From: Rs 1,525.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 7 - Lobster -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/128408/pexels-photo-128408.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Lobster">
                            <div class="card-body">
                                <h5 class="card-title">Lobster</h5>
                                <p class="price">From: Rs 4,500.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 8 - Salmon Fillet -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/3296277/pexels-photo-3296277.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Salmon Fillet">
                            <div class="card-body">
                                <h5 class="card-title">Salmon Fillet</h5>
                                <p class="price">From: Rs 2,250.00</p>
                            </div>
                        </div>
                    </div>

                    <!-- Product 9 - Tuna Steak -->
                    <div class="col-md-4 col-sm-6">
                        <div class="card product-card">
                            <img src="https://images.pexels.com/photos/128388/pexels-photo-128388.jpeg?auto=compress&cs=tinysrgb&w=800"
                                class="card-img-top" alt="Tuna Steak">
                            <div class="card-body">
                                <h5 class="card-title">Tuna Steak</h5>
                                <p class="price">From: Rs 1,780.00</p>
                            </div>
                        </div>
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
