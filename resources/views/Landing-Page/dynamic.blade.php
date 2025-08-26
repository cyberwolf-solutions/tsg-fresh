@extends('landing-page.layouts.app')

@section('content')
    <style>
        /* Main Styles */
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Hero Banner */
        .hero-banner {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('https://tsg-fresh.com/wp-content/uploads/2023/06/Untitled-1-1.jpg');
            background-size: cover;
            background-position: center;
            padding: 50px 0;
            color: #fff;
            text-align: center;
            margin-bottom: 20px;
            display: none;
        }

        .hero-banner h1 {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            font-size: 12px;
            margin-bottom: 20px;
            color: #666;
        }

        .breadcrumb-item a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #333;
            font-weight: bold;
        }

        /* Product Grid */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            position: relative;
            background: #fff;
            text-align: center;
        }

        .product-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-card .card-img-top {
            border-radius: 5px 5px 0 0;
            height: 150px;
            object-fit: cover;
            width: 100%;
        }

        .product-card .card-body {
            padding: 10px;
        }

        .product-card .card-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .product-card .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 0;
        }

        .out-of-stock {
            color: #e74c3c;
            font-weight: bold;
            font-size: 12px;
            margin-top: 5px;
        }

        /* Sidebar */
        .sidebar-widget {
            background: #fff;
            padding: 15px;
            margin-bottom: 20px;
            /* border: 1px solid #ddd; */
            border-radius: 5px;
        }

        .sidebar-widget h4 {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
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
            font-size: 14px;
        }

        .price-slider {
            width: 100%;
            height: 5px;
            background: #ddd;
            outline: none;
            margin-top: 10px;
        }

        .price-slider::-webkit-slider-thumb {
            width: 12px;
            height: 12px;
            background: #e74c3c;
            border-radius: 50%;
            cursor: pointer;
        }

        .price-range {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            color: #666;
        }

        .btn-filter {
            background-color: #8b7f7e;
            color: #fff;
            border: none;
            padding: 8px 15px;
            font-size: 12px;
            margin-top: 10px;
            border-radius: 16px;
        }

        .btn-filter:hover {
            background-color: #8b7f7e;
        }

        /* Sorting */
        .sorting-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .sorting-options .form-select {
            width: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px 10px;
            font-size: 12px;
        }

        /* Footer */
        .footer {
            background-color: #fff;
            padding: 40px 0;
            margin-top: 30px;
            border-top: 1px solid #ddd;
        }

        .footer-widget {
            margin-bottom: 20px;
        }

        .footer-widget h5 {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
        }

        .footer-product {
            display: flex;
            margin-bottom: 10px;
            align-items: center;
        }

        .footer-product img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 5px;
        }

        .footer-product-info h6 {
            font-size: 12px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .footer-product-info .price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 12px;
        }

        .footer-product-info .rating {
            color: #f1c40f;
            font-size: 10px;
            margin: 2px 0;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-banner h1 {
                font-size: 28px;
            }

            .col-lg-3 {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 767px) {
            .hero-banner {
                padding: 30px 0;
            }

            .hero-banner h1 {
                font-size: 20px;
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
            padding: 0 15px;
            max-width: 1200px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .page-item {
            margin: 0 5px;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
            font-size: 14px;
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background-color: #f0f0f0;
        }

        .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #ddd;
        }

        .toast-container {
            z-index: 9999 !important;
        }

        .toast {
            min-width: 300px;
        }
    </style>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 11000">
        <!-- Toast Template -->
        <div id="liveToast" class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    ⚠️ This is a sample toast message.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Hero Banner -->
    <div class="hero-banner">
        <div class="container">
            <h1>Shop</h1>
        </div>
    </div>

    <div class="centered-wrapper">
        <!-- Main Content -->
        <div class="container mb-5" style="margin-top: 80px;">

            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb mt-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shop</li>
                </ol>
            </nav>
            <div class="col-md-12 mt-5 active mb-4 text-end">
                <div class="sorting-options d-flex justify-content-end align-items-center gap-3">
                   <p class="mb-0 text-secondary d-none d-lg-block">
    Showing
    {{ ($products->currentPage() - 1) * $products->perPage() + 1 }}&ndash;{{ min($products->currentPage() * $products->perPage(), $products->total()) }}
    of {{ $products->total() }} results
</p>

                    <select class="form-select w-auto " style="font-size: 1em;">
                        <option>Default sorting</option>
                        <option>Sort by popularity</option>
                        <option>Sort by average rating</option>
                        <option>Sort by latest</option>
                        <option>Sort by price: low to high</option>
                        <option>Sort by price: high to low</option>
                    </select>
                </div>
            </div>

            <div class="row mt-4">


                {{-- <div class="col-lg-3 py-0">

                    <div class="sidebar-widget">
                        <h4 class="text-secondary">BROWSE</h4>
                        <ul id="category-list" class=" mb-3">
                            @foreach ($categories as $category)
                                <li class="">
                                    <a class="text-dark" style="font-size: 1.2em;" href="#"
                                        data-id="{{ $category->id }}">{{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <h4 class="text-secondary mt-4">FILTER BY PRICE</h4>
                        <input type="range" class="price-slider" min="0" max="15400" value="5130">
                        <div class="price-range">
                            <button class="btn btn-filter fw-bold">FILTER</button>
                            <span class="mt-3" style="font-size: 1.2em;">Price: රු5130 - රු15,400</span>
                        </div>

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
                </div> --}}

                <!-- DESKTOP SIDEBAR (Visible only on lg+) -->
                <div class="col-lg-3 py-0 d-none d-lg-block">
                    <div class="sidebar-widget">
                        <h4 class="text-secondary">BROWSE</h4>
                        <ul id="category-list" class="mb-3">
                            @foreach ($categories as $category)
                                <li>
                                    <a class="text-dark" style="font-size: 1.2em;" href="#"
                                        data-id="{{ $category->id }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <h4 class="text-secondary mt-4">FILTER BY PRICE</h4>
                        <input type="range" class="price-slider" min="0" max="15400" value="5130">
                        <div class="price-range">
                            <button class="btn btn-filter fw-bold">FILTER</button>
                            <span class="mt-3" style="font-size: 1.2em;">Price: රු5130 - රු15,400</span>
                        </div>
                    </div>

                    <!-- Recently Viewed -->
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

                    <!-- Banner -->
                    <div class="sidebar-widget p-0 border-0" style="box-shadow:none;">
                        <img src="{{ asset('build/images/image.png') }}" class="img-fluid" alt="Promotional Banner">
                    </div>
                </div>


                <!-- MOBILE FILTER BUTTON (Hidden on Desktop) -->
               <!-- Mobile Filter Button -->
<div class="d-lg-none text-center mb-3">
  <button class="btn btn-sm fw-bold text-secondary border-0 bg-transparent p-0 d-inline-flex align-items-center gap-1"
          data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
      <i class="bi bi-list fs-5"></i> Filters
  </button>
</div>



                <!-- OFFCANVAS FILTER (MOBILE ONLY) -->
                <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title">Filters</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body">
                        <!-- Same Sidebar Content -->
                        <div class="sidebar-widget">
                            <h4 class="text-secondary">BROWSE</h4>
                            <ul id="category-list-mobile" class="mb-3">
                                @foreach ($categories as $category)
                                    <li>
                                        <a class="text-dark" style="font-size: 1.2em;" href="#"
                                            data-id="{{ $category->id }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>

                            <h4 class="text-secondary mt-4">FILTER BY PRICE</h4>
                            <input type="range" class="price-slider" min="0" max="15400" value="5130">
                            <div class="price-range">
                                <button class="btn btn-filter fw-bold">FILTER</button>
                                <span class="mt-3" style="font-size: 1.2em;">Price: රු5130 - රු15,400</span>
                            </div>
                        </div>

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

                        <div class="sidebar-widget p-0 border-0" style="box-shadow:none;">
                            <img src="{{ asset('build/images/image.png') }}" class="img-fluid" alt="Promotional Banner">
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-lg-9">
                    <!-- Sorting Options -->


                    <!-- Product Grid -->
                    <div id="product-grid">
                        @include('Landing-Page.partials.product-grid', ['products' => $products])
                    </div>
                    <div class="pagination mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item {{ $products->currentPage() == 1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $products->lastPage(); $i++)
                                    <li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li
                                    class="page-item {{ $products->currentPage() == $products->lastPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    @include('Landing-Page.partials.products')
    {{-- @include('partials.footer', [
        'latestProducts' => \App\Models\Product::latest()->take(4)->get(),
        'bestSellingProducts' => collect(), // or preload in controller
        'topRatedProducts' => collect(),
    ]) --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the toast
            var toastEl = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastEl, {
                autohide: true,
                delay: 3000
            });

            // Store the toast instance for global access
            window.appToast = toast;
        });

        function showToast(message, type = "warning") {
            let toastEl = document.getElementById("liveToast");
            let toastMessage = document.getElementById("toastMessage");

            // Change text
            toastMessage.innerHTML = message;

            // Change color based on type
            toastEl.classList.remove("text-bg-success", "text-bg-danger", "text-bg-warning");
            if (type === "success") toastEl.classList.add("text-bg-success");
            else if (type === "error") toastEl.classList.add("text-bg-danger");
            else toastEl.classList.add("text-bg-warning");

            // Show toast using the stored instance or create a new one
            if (window.appToast) {
                window.appToast.show();
            } else {
                let toast = new bootstrap.Toast(toastEl, {
                    delay: 3000
                });
                toast.show();
            }
        }



        document.addEventListener('DOMContentLoaded', function() {
            // Handle category clicks
            document.querySelectorAll('#category-list a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.getAttribute('data-id');

                    // Get current URL and parameters
                    const url = new URL(window.location.href);

                    // Toggle category filter - if same category clicked again, remove filter
                    if (url.searchParams.get('category_id') === categoryId) {
                        url.searchParams.delete('category_id');
                        this.classList.remove('active');
                    } else {
                        url.searchParams.set('category_id', categoryId);
                        // Remove active class from all and add to clicked one
                        document.querySelectorAll('#category-list a').forEach(a => a.classList
                            .remove('active'));
                        this.classList.add('active');
                    }

                    // Always reset to first page when changing filters
                    url.searchParams.delete('page');

                    loadProducts(url.toString());
                });
            });

            // Initialize active category from URL if present
            const urlParams = new URLSearchParams(window.location.search);
            const activeCategoryId = urlParams.get('category_id');
            if (activeCategoryId) {
                const activeLink = document.querySelector(`#category-list a[data-id="${activeCategoryId}"]`);
                if (activeLink) {
                    activeLink.classList.add('active');
                }
            }

            // Rest of your existing code (price filter, pagination, etc.)
            document.querySelector('.btn-filter').addEventListener('click', function() {
                const priceValue = document.querySelector('.price-slider').value;
                const url = new URL(window.location.href);
                url.searchParams.set('min_price', priceValue);
                url.searchParams.delete('page');
                loadProducts(url.toString());
            });

            document.addEventListener('click', function(e) {
                const paginationLink = e.target.closest('.pagination a');
                if (paginationLink) {
                    e.preventDefault();
                    loadProducts(paginationLink.href);
                }
            });

            function loadProducts(url) {
                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(html => {
                        document.querySelector('#product-grid').innerHTML = html;
                        history.pushState(null, null, url);
                        document.querySelector('#product-grid').scrollIntoView({
                            behavior: 'smooth'
                        });
                    })
                    .catch(error => {
                        console.error('Error loading products:', error);

                        showToast('Failed to load products. Please try again.');
                    });
            }

            window.addEventListener('popstate', function(event) {
                loadProducts(window.location.href);
            });

            // Price slider functionality
            const slider = document.querySelector('.price-slider');
            const priceDisplay = document.querySelector('.price-range span');
            const min = parseInt(slider.min);
            const max = parseInt(slider.max);
            const range = max - min;

            function updateSlider() {
                const value = parseInt(slider.value);
                const percentage = ((value - min) / range) * 100;
                slider.style.background =
                    `linear-gradient(to right, #fff 0%, #fff ${percentage}%, #ffcccc ${percentage}%, #ffcccc 100%)`;
                priceDisplay.textContent = `Price: රු${value.toLocaleString()} - රු${max.toLocaleString()}`;
            }

            slider.addEventListener('input', updateSlider);
            updateSlider();
        });
    </script>
@endsection
