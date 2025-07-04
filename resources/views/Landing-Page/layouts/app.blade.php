<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Taprobane Fresh - Premium Seafood Solutions">
    <meta name="author" content="CyberWolf Solutions (Pvt) Ltd.">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Taprobane Fresh')</title>

    <!-- Bootstrap 5.3.2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Landing CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        header,
        footer {
            color: black;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
        }

        .hero {
            background: url('/images/seafood-banner.jpg') no-repeat center center;
            background-size: cover;
            text-align: center;
            padding: 100px 20px;
            color: white;
        }

        .btn {
            background: #ff6600;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
        }

        .section {
            padding: 40px 20px;
            text-align: center;
        }

        .object-fit-cover {
            object-fit: cover;
        }
    </style>

    @stack('styles')
</head>

<body>
    @include('landing-page.layouts.header')

    <div class="main-content">
        <main class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
        @include('landing-page.layouts.footer')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}



    @push('scripts')
        <script>
            let prevScrollPos = window.pageYOffset;
            const headerWrapper = document.getElementById("headerWrapper");

            window.addEventListener("scroll", function() {
                const currentScrollPos = window.pageYOffset;

                if (prevScrollPos > currentScrollPos) {
                    // Scroll up
                    headerWrapper.style.transform = "translateY(0)";
                } else {
                    // Scroll down
                    headerWrapper.style.transform = "translateY(-100%)";
                }

                prevScrollPos = currentScrollPos;
            });
        </script>
    @endpush


</body>

</html>
