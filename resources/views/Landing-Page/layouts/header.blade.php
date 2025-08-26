
<header id="headerWrapper"
    style="position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; transition: transform 0.3s ease-in-out;">

    @include('Landing-Page.PARTIALS.auth-modals')
    <style>
        /* Prevent horizontal scroll on small screens */
        html,
        body {
            overflow-x: hidden;
        }

        /* Make mobile search input responsive */
        #mobileSearchBar input {
            max-width: calc(100vw - 100px);
            /* adjust depending on icons width */
        }

        /* Ensure dropdowns stay within viewport */
        .account-dropdown .dropdown-content {
            right: 0;
            left: auto;
            max-width: 90vw;
            box-sizing: border-box;
        }

        /* Ensure mobile header content doesn't overflow */
        #mobileHeader {
            box-sizing: border-box;
            padding: 10px;
            width: 100%;
        }


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

    </style>
    <style>
        /* Hide original nav for small screens */
        @media (max-width: 991px) {
            nav {
                display: none;
                /* hide current nav */
            }

            /* Mobile header container */
            #mobileHeader {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px;
                background-color: white;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 9999;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            #mobileHeader .mobile-logo img {
                height: 50px;
            }

            #mobileHeader .mobile-icons {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            #mobileHeader .mobile-icons i {
                font-size: 20px;
                cursor: pointer;
                color: #333;
            }

            /* Optional: Hide desktop topbar for small screens */
            #topBar {
                display: none;
            }
        }

        /* Show desktop nav on medium+ screens */
        @media (min-width: 992px) {
            #mobileHeader {
                display: none;
            }
        }

        /* Mobile Sidebar */
        #mobileSidebar {
            position: fixed;
            top: 0;
            left: -250px;
            width: 250px;
            height: 100%;
            background-color: white;
            z-index: 10000;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            transition: left 0.3s ease-in-out;
        }

        #mobileSidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #mobileSidebar ul li {
            margin: 15px 0;
        }

        #mobileSidebar ul li a {
            text-decoration: none;
            font-weight: bold;
            color: #333;
            font-size: 16px;
        }

        #closeMobileSidebar {
            font-size: 28px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        #mobileSidebarOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: none;
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

    <!-- Mobile Top Info Bar -->
    <!-- Mobile Top Info Bar -->
    <div id="mobileTopBar" class="d-flex d-lg-none justify-content-between align-items-center px-3"
        style="background-color: rgb(0,120,206); color: rgb(228,228,228); font-size: 12px; height: 30px; position: fixed; top: 0; left: 0; width: 100%; z-index: 10000;">
        <div style="display: flex; align-items: center; gap: 5px;">
            <i class="fas fa-location-dot"></i>
            #38, CHARLES DRIVE, KOLLUPITIYA, COLOMBO 3
        </div>
        <div style="display: flex; align-items: center; gap: 5px;">
            <i class="fas fa-phone-alt"></i>
            +94774000010
        </div>
    </div>

    <!-- Mobile Header with Logo and Menu -->
    <div id="mobileHeader" class="d-flex d-lg-none justify-content-between align-items-center px-3"
        style="position: fixed; top: 30px; left: 0; width: 100%; z-index: 9999; background-color: white; height: 60px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">

        <div class="mobile-icons">
            <i class="fas fa-bars" id="mobileMenuToggle"></i>
        </div>

        <div style="display: flex; align-items: center;">
            <div id="mobileSearchButton" class="search-icon" style="cursor: pointer;">
                <i class="fas fa-search" style="font-size: 18px; color: #333;"></i>
            </div>
            <div id="mobileSearchBar" style="display: none; margin-left: 10px;">
                <form id="searchForm" action="{{ route('shopnow.product') }}" method="GET">
                    <input type="text" name="search" id="searchInput" placeholder="Search..."
                        style="padding: 5px 10px; border: 1px solid #ddd; border-radius: 4px; outline: none;">
                    <button type="submit" style="display: none;"></button>
                </form>
            </div>
        </div>


        <div class="mobile-logo mx-auto">
            <img src="{{ asset('build/images/landing/flogo.png') }}" alt="Logo" style="height: 50px;">
        </div>

        @if (Auth::guard('customer')->check())
            <div class="account-dropdown" style="position: relative; display: inline-block;">
                <div id="accountButton"
                    style="display: flex; align-items: center; gap: 5px; cursor: pointer; background-color: #e0e0e0; border-radius: 20px; padding: 5px 10px;">
                    <span style="font-size: 14px; color: #666; font-weight: normal;">MY ACCOUNT</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="#666" style="margin-left: 5px;">
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
                                <a href="{{ route('customer.order.index') }}"
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
            <div id="mobileLoginButton" style="display: flex; align-items: center; gap: 5px; cursor: pointer;">
                <span style="font-size: 14px; color: #333;">LOGIN</span>
            </div>
        @endif
        <div style="height: 20px; width: 1px; background-color: #ccc;"></div>

        <!-- Cart -->
        <div id="mobileCartButton"
            style="display: flex; align-items: center; gap: 5px; cursor: pointer; position: relative;">

            <i class="fas fa-shopping-cart" style="font-size: 18px; color: #333; margin-left: 5px;"></i>
            <span id="cartCount"
                style="position: absolute; top: -8px; right: -8px; background-color: #0078ce; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px;">0</span>
        </div>

    </div>



    <!-- Mobile Sidebar Navigation -->
    <div id="mobileSidebar">
        <div id="closeMobileSidebar">&times;</div>
        <ul>
            <li><a href="{{ url('/landing') }}">HOME</a></li>
            <li><a href="{{ url('/about') }}">ABOUT US</a></li>
            <li><a href="{{ url('/shop-now') }}">SHOP NOW</a></li>
            <li><a href="{{ url('/contact') }}">CONTACT</a></li>
        </ul>
    </div>
    <div id="mobileSidebarOverlay"></div>
    <!-- Main Navigation -->
    <nav class="d-none d-lg-flex"
        style="height: 60px; background-color: white; align-items: center; justify-content: space-between; padding: 0 20px; height: 90px;">

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
                                        <a href="{{ route('customer.order.index') }}"
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
                    style="display: flex; align-items: center; gap: 5px; cursor: pointer; position: relative;">
                    <span style="font-size: 14px; font-weight: bold; color: #333;">CART / </span>
                    <span id="cartTotal" style="font-size: 14px; color: #333;">රු0.00</span>
                    <i class="fas fa-shopping-cart" style="font-size: 18px; color: #333; margin-left: 5px;"></i>
                    <span id="cartCount"
                        style="position: absolute; top: -8px; right: -8px; background-color: #0078ce; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 10px;">0</span>
                </div>

            </div>
        @endif
    </nav>


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
        const mobileToggle = document.getElementById('mobileMenuToggle');
        const mobileSidebar = document.getElementById('mobileSidebar');
        const closeMobileSidebar = document.getElementById('closeMobileSidebar');
        const sidebarOverlay = document.getElementById('mobileSidebarOverlay');

        function openSidebar() {
            mobileSidebar.style.left = '0';
            sidebarOverlay.style.display = 'block';
        }

        function closeSidebar() {
            mobileSidebar.style.left = '-250px';
            sidebarOverlay.style.display = 'none';
        }

        if (mobileToggle) {
            mobileToggle.addEventListener('click', openSidebar);
        }

        if (closeMobileSidebar) {
            closeMobileSidebar.addEventListener('click', closeSidebar);
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize cart on page load
        updateHeaderCart();

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
                loadCartItems(); // Load cart items when opening sidebar
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

        // --- ACCOUNT DROPDOWN ---
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
                    searchInput.focus();
                } else {
                    searchBar.style.display = 'none';
                }
            });
        }

        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    window.location.href =
                        `{{ route('shopnow.product') }}?search=${encodeURIComponent(searchTerm)}`;
                    searchBar.style.display = 'none';
                    searchInput.value = '';
                }
            });
        }

        // Function to update header cart count and total
        function updateHeaderCart() {
            fetch("{{ route('cart.sidebar') }}")
                .then(res => res.text())
                .then(html => {
                    // Create a temporary container to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    // Get total quantity and subtotal
                    const totalQty = parseInt(tempDiv.querySelector('#cartTotalQty')?.innerText || 0);
                    const subtotal = parseFloat(tempDiv.querySelector('#cartSubtotalValue')?.dataset
                        .subtotal || 0);

                    // Update header UI
                    document.getElementById('cartCount').innerText = totalQty;
                    document.getElementById('cartTotal').innerText =
                        `රු${subtotal.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                })
                .catch(err => {
                    console.error('Error fetching cart data:', err);
                    document.getElementById('cartCount').innerText = '0';
                    document.getElementById('cartTotal').innerText = 'රු0.00';
                });
        }

        // Load cart items for sidebar
        function loadCartItems() {
            fetch("{{ route('cart.sidebar') }}")
                .then(res => res.text())
                .then(html => {
                    document.getElementById('cartItems').innerHTML = html;

                    // Update header cart after loading sidebar
                    const totalQty = parseInt(document.getElementById('cartTotalQty')?.innerText || 0);
                    const subtotal = parseFloat(document.getElementById('cartSubtotalValue')?.dataset
                        .subtotal || 0);

                    document.getElementById('cartCount').innerText = totalQty;
                    document.getElementById('cartTotal').innerText =
                        `රු${subtotal.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                })
                .catch(err => {
                    console.error('Error loading cart items:', err);
                    document.getElementById('cartItems').innerHTML = '<p>Failed to load cart.</p>';
                });
        }

        // Open offcanvas and load cart items
        function openHeaderCart() {
            loadCartItems();
            var offcanvasEl = document.getElementById('offcanvasCart');
            var bsOffcanvas = new bootstrap.Offcanvas(offcanvasEl);
            bsOffcanvas.show();
        }

        // Attach click event to header cart button
        cartButton.addEventListener('click', openHeaderCart);
    });

    // Consolidated removeCartItem function
    function removeCartItem(itemId) {
        if (!confirm("Remove this item from cart?")) return;

        fetch(`/cart/item/${itemId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Update sidebar content
                    document.getElementById("cartItems").innerHTML = data.html;

                    // Update header cart
                    const totalQty = parseInt(document.getElementById('cartTotalQty')?.innerText || 0);
                    const subtotal = parseFloat(document.getElementById('cartSubtotalValue')?.dataset.subtotal ||
                        0);

                    document.getElementById('cartCount').innerText = totalQty;
                    document.getElementById('cartTotal').innerText =
                        `රු${subtotal.toLocaleString('en-LK', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                } else {
                    alert(data.message || "Something went wrong!");
                }
            })
            .catch(err => {
                console.error('Error removing cart item:', err);
                alert("Failed to remove item from cart.");
            });
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // --- MOBILE SEARCH FUNCTIONALITY ---
        const mobileSearchButton = document.getElementById('mobileSearchButton');
        const mobileSearchBar = document.getElementById('mobileSearchBar');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const mobileSearchForm = document.getElementById('mobileSearchForm');

        if (mobileSearchButton && mobileSearchBar) {
            mobileSearchButton.addEventListener('click', function() {
                if (mobileSearchBar.style.display === 'none' || !mobileSearchBar.style.display) {
                    mobileSearchBar.style.display = 'block';
                    mobileSearchInput.focus();
                } else {
                    mobileSearchBar.style.display = 'none';
                }
            });
        }

        if (mobileSearchForm) {
            mobileSearchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = mobileSearchInput.value.trim();
                if (searchTerm) {
                    window.location.href =
                        `{{ route('shopnow.product') }}?search=${encodeURIComponent(searchTerm)}`;
                    mobileSearchBar.style.display = 'none';
                    mobileSearchInput.value = '';
                }
            });
        }

        // --- MOBILE LOGIN FUNCTIONALITY ---
        const mobileLoginButton = document.getElementById('mobileLoginButton');
        const loginModal = document.getElementById('loginModal'); // same modal for desktop and mobile
        const closeLogin = document.getElementById('closeLogin');

        if (mobileLoginButton && loginModal) {
            mobileLoginButton.addEventListener('click', function() {
                loginModal.style.display = 'flex';
            });

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


    });
</script>
