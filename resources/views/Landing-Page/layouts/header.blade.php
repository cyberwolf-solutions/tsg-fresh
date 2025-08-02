<header id="headerWrapper"
    style="position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; transition: transform 0.3s ease-in-out;">
    <!-- Blue Top Bar -->
    <div id="topBar"
        style="background-color: rgb(0, 120, 206); height: 30px; display: flex; align-items: center; justify-content: space-between; padding: 0 15px; font-size: 11px;">
        <div style="color: rgb(228, 228, 228);">+94774000010 | 23B, Charles Drive, Kollupitiya, Colombo 3</div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <a href="{ route('landing.about') }}" style="color: rgb(228, 228, 228); text-decoration: none;">About Us</a>
            <span style="color: rgb(228, 228, 228);">|</span>
            <a href="{ route('landing.contact') }}" style="color: rgb(228, 228, 228); text-decoration: none;">Contact
                Us</a>
            <span style="color: rgb(228, 228, 228);">|</span>
            <a href="https://facebook.com" target="_blank" style="color: white;"><i class="fab fa-facebook-f"></i></a>
            <a href="https://instagram.com" target="_blank" style="color: white;"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav
        style="height: 60px; background-color: white; display: flex; align-items: center; justify-content: space-between; padding: 0 20px;">
        <!-- Left Links -->
        <ul style="display: flex; list-style: none; gap: 20px; margin: 0; padding: 0;">
            <li><a href="{{ url('/landing') }}" class="nav-link {{ request()->is('landing') ? 'active' : '' }}">HOME</a>
            </li>
            <li><a href="{{ url('/about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">ABOUT US</a>
            </li>
            <li><a href="{{ url('/shop-now') }}" class="nav-link {{ request()->is('shop-now') ? 'active' : '' }}">SHOP
                    NOW</a></li>
            {{-- <li><a href="{{ url('/cart') }}" class="nav-link {{ request()->is('cart') ? 'active' : '' }}">CART</a></li>
            <li><a href="{{ url('/checkout') }}"
                    class="nav-link {{ request()->is('checkout') ? 'active' : '' }}">CHECKOUT</a></li> --}}
            <li><a href="{{ url('/contact') }}"
                    class="nav-link {{ request()->is('contact') ? 'active' : '' }}">CONTACT</a></li>

        </ul>

        <!-- Centered Logo -->
        <div style="position: absolute; left: 50%; transform: translateX(-50%);">
            <img src="{{ asset('build/images/landing/flogo.png') }}" alt="Logo" style="height: 60px;">
        </div>
    </nav>

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
