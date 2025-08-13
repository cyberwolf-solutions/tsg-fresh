<header id="headerWrapper"
    style="position: fixed; top: 0; left: 0; width: 100%; z-index: 9999; transition: transform 0.3s ease-in-out;">
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
