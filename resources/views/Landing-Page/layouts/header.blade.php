<header id="headerWrapper"
    style="position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; transition: transform 0.3s ease-in-out;">

    @include('Landing-Page.PARTIALS.auth-modals')
    <style>
        .account-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
            padding: 15px;
        }

        .account-dropdown:hover .dropdown-content {
            display: block;
        }

        .account-button {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        .account-button:hover {
            color: #007BFF;
        }
    </style>
    <!-- Blue Top Bar -->
    <div id="topBar"
        style="background-color: rgb(0, 120, 206); height: 30px; display: flex; align-items: center; justify-content: space-between; padding: 0 15px; font-size: 12px; font-family: Arial, sans-serif;">
        <div style="color: rgb(228, 228, 228);">
            <i class="fas fa-location-dot" style="margin-right: 5px;"></i>
            #38, CHARLES DRIVE, KOLLUPITIYA, COLOMBO 3&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
            <i class="fas fa-phone-alt" style="margin-right: 3px;"></i>
            +94774000010
        </div>

        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{ route('landing.about') }" style="color: rgb(228, 228, 228); text-decoration: none;">AboutUs</a>
            <span style="color: rgb(228, 228, 228);">|</span>
            <a href="{ route('landing.contact') }"
                style="color: rgb(228, 228, 228); text-decoration: none;">ContactUs</a>
            <a href="https://facebook.com" target="_blank" style="color: white;"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com" target="_blank" style="color: white;"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Main Navigation -->
    <nav
        style="height: 60px; background-color: white; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; height: 90px;">
        <!-- Left Links -->
        <ul style="display: flex; list-style: none; gap: 20px; margin: 0; padding: 0;">
            <li><a href="{{ url('/landing') }}" class="nav-link {{ request()->is('landing') ? 'active' : '' }}"
                    style="font-size: 15px; font-weight: bold;">HOME</a></li>
            <li><a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                    style="font-size: 15px; font-weight: bold;">ABOUT US</a></li>
            <li><a href="{{ url('/shop-now') }}" class="nav-link {{ request()->is('shop-now') ? 'active' : '' }}"
                    style="font-size: 15px; font-weight: bold;">SHOP NOW</a></li>
            <li><a href="{{ url('/contact') }}" class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                    style="font-size: 15px; font-weight: bold;">CONTACT</a></li>
        </ul>

        <!-- Centered Logo -->
        <div style="position: absolute; left: 50%; transform: translateX(-50%);" class="mt-1">
            <img src="{{ asset('build/images/landing/flogo.png') }}" alt="Logo" style="height: 90px;">
        </div>

        <!-- Right Icons -->
        @if (request()->is(['shop-now', 'single*', 'cart*']))
            <div style="display: flex; align-items: center; gap: 10px;">
                <!-- Search Icon and Search Bar -->
                <div style="display: flex; align-items: center;">
                    <div id="searchButton" class="search-icon" style="cursor: pointer;">
                        <i class="fas fa-search" style="font-size: 18px; color: #333;"></i>
                    </div>
                    <div id="searchBar" style="display: none; margin-left: 10px;">
                        <form id="searchForm" action="{{ route('shopnow.product') }}" method="GET">
                            <input type="text" name="search" id="searchInput" placeholder="Search..."
                                style="padding: 5px 10px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                            <button type="submit" style="display: none;"></button>
                        </form>
                    </div>
                </div>

                <!-- Vertical Divider -->
                <div style="height: 20px; width: 1px; background-color: #ccc;"></div>

                <!-- Login -->
                @if (Auth::guard('customer')->check())
                    <div class="account-dropdown" style="position: relative; display: inline-block;">
                        <div id="accountButton"
                            style="display: flex; align-items: center; gap: 5px; cursor: pointer; background-color: #e0e0e0; border-radius: 20px; padding: 5px 10px;">
                            <span style="font-size: 14px; color: #666; font-weight: normal;">MY ACCOUNT</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="#666"
                                style="margin-left: 5px;">
                                <path
                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>

                        <div class="dropdown-content"
                            style="display: none; position: absolute; right: 0; background-color: #f9f9f9; min-width: 200px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; padding: 15px;">


                            <div style="border-top: 1px solid #eee; padding-top: 10px;">

                                <ul style="list-style: none; padding: 0; margin: 0; font-size: 13px;">
                                    <li style="padding: 3px 0;">
                                        <a href="{{ route('customer.dashboard') }}"
                                            style="text-decoration: none; color: #333; display: block;">Dashboard</a>
                                        <hr style="margin: 3px 0; border: none; border-top: 1px solid #eee;">
                                    </li>
                                    <li style="padding: 3px 0;">
                                        <a href="{{ route('customer.dashboard') }}"
                                            style="text-decoration: none; color: #333; display: block;">Orders</a>
                                        <hr style="margin: 3px 0; border: none; border-top: 1px solid #eee;">
                                    </li>
                                    <li style="padding: 3px 0;">
                                        <a href="{{ route('customer.dashboard') }}"
                                            style="text-decoration: none; color: #333; display: block;">Downloads</a>
                                        <hr style="margin: 3px 0; border: none; border-top: 1px solid #eee;">
                                    </li>
                                    <li style="padding: 3px 0;">
                                        <a href="{{ route('customer.address') }}"
                                            style="text-decoration: none; color: #333; display: block;">Addresses</a>
                                        <hr style="margin: 3px 0; border: none; border-top: 1px solid #eee;">
                                    </li>
                                    <li style="padding: 3px 0;">
                                        <a href="{{ route('customer.account') }}"
                                            style="text-decoration: none; color: #333; display: block;">Account
                                            details</a>
                                        <hr style="margin: 3px 0; border: none; border-top: 1px solid #eee;">
                                    </li>
                                    <li style="padding: 3px 0;">
                                        <form method="POST" action="{{ route('customer.logout') }}">
                                            @csrf
                                            <button type="submit"
                                                style="background: none; border: none; padding: 0; color: #333; cursor: pointer; font-size: 13px;">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <div id="loginButton" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                        <span style="font-size: 14px; color: #333;">LOGIN</span>
                    </div>
                @endif

                <!-- Vertical Divider -->
                <div style="height: 20px; width: 1px; background-color: #ccc;"></div>

                <!-- Cart -->
                <div id="cartButton"
                    style="display: flex; align-items: center; gap: 5px; cursor: pointer; position: relative;"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                    <span style="font-size: 14px; font-weight: bold; color: #333;">CART / </span>
                    <span style="font-size: 14px; color: #333;">$0.00</span>
                    <i class="fas fa-shopping-cart" style="font-size: 18px; color: #333; margin-left: 5px;"></i>
                    <span id="cartCount"
                        style="position: absolute; top: -8px; right: -8px; background-color: #0078ce; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px;">0</span>
                </div>
            </div>
        @endif
    </nav>

    <!-- Full-screen Cart Overlay -->
    {{-- <div id="cartOverlay"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9998; display: none;">
        <!-- Cart Sidebar -->
        <div id="cartSidebar"
            style="position: fixed; top: 0; right: -400px; width: 350px; height: 100%; background-color: white; transition: right 0.3s ease; z-index: 9999; padding: 20px; overflow-y: auto;">
            <div
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-top: 30px;">
                <h3 style="font-size: 18px; font-weight: bold;">CART</h3>
                <button id="closeCart"
                    style="background: none; border: none; font-size: 20px; cursor: pointer;">×</button>
            </div>

            <div id="cartContent" style="text-align: center; padding: 40px 0;">
                <p>No products in the cart.</p>
                <a href="{{ url('/shop-now') }}"
                    style="display: inline-block; margin-top: 20px; padding: 10px 20px; background-color: #0078ce; color: white; text-decoration: none;">RETURN
                    TO SHOP</a>
            </div>
        </div>
    </div> --}}
    @include('landing-page.partials.cart')
    <!-- Login Modal -->




    <style>
        .nav-link {
            text-decoration: none;
            color: gray;
            font-weight: 500;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            font-size: 12px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: black;
            border-bottom: 3px solid rgb(0, 120, 206);
        }
    </style>
</header>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- CART FUNCTIONALITY ---
        const cartButton = document.getElementById('cartButton');
        const cartOverlay = document.getElementById('cartOverlay');
        const cartSidebar = document.getElementById('cartSidebar');
        const closeCart = document.getElementById('closeCart');

        function closeCartFunction() {
            if (cartSidebar) {
                cartSidebar.style.right = '-400px';
            }
            if (cartOverlay) {
                setTimeout(() => {
                    cartOverlay.style.display = 'none';
                }, 300);
            }
        }

        if (cartButton && cartOverlay && cartSidebar) {
            cartButton.addEventListener('click', function() {
                cartOverlay.style.display = 'block';
                setTimeout(() => {
                    cartSidebar.style.right = '0';
                }, 10);
            });
        }

        if (closeCart) {
            closeCart.addEventListener('click', closeCartFunction);
        }

        if (cartOverlay) {
            cartOverlay.addEventListener('click', function(event) {
                if (event.target === cartOverlay) {
                    closeCartFunction();
                }
            });
        }

        // --- LOGIN FUNCTIONALITY ---
        const loginButton = document.getElementById('loginButton');
        const loginModal = document.getElementById('loginModal');
        const closeLogin = document.getElementById('closeLogin');

        if (loginButton && loginModal) {
            loginButton.addEventListener('click', function() {
                loginModal.style.display = 'flex';
            });

            // Close login modal when clicking outside
            loginModal.addEventListener('click', function(event) {
                if (event.target === loginModal) {
                    loginModal.style.display = 'none';
                }
            });
        }

        if (closeLogin && loginModal) {
            closeLogin.addEventListener('click', function() {
                loginModal.style.display = 'none';
            });
        }



        // --- ACCOUNT DROPDOWN (for logged-in users) ---
        const accountDropdown = document.querySelector('.account-dropdown');
        if (accountDropdown) {
            accountDropdown.addEventListener('mouseenter', function() {
                const dropdown = this.querySelector('.dropdown-content');
                if (dropdown) dropdown.style.display = 'block';
            });

            accountDropdown.addEventListener('mouseleave', function() {
                const dropdown = this.querySelector('.dropdown-content');
                if (dropdown) dropdown.style.display = 'none';
            });
        }


        // --- SEARCH FUNCTIONALITY ---
        const searchButton = document.getElementById('searchButton');
        const searchBar = document.getElementById('searchBar');
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        if (searchButton && searchBar) {
            searchButton.addEventListener('click', function() {
                if (searchBar.style.display === 'none' || !searchBar.style.display) {
                    searchBar.style.display = 'block';
                    searchInput.focus(); // Focus the input when shown
                } else {
                    searchBar.style.display = 'none';
                }
            });
        }

        // Handle search form submission
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.trim();

                if (searchTerm) {
                    // Redirect to shop page with search parameter
                    window.location.href =
                        `{{ route('shopnow.product') }}?search=${encodeURIComponent(searchTerm)}`;

                    // Close search bar after search
                    searchBar.style.display = 'none';
                    searchInput.value = '';
                }
            });
        }
    });
</script>
