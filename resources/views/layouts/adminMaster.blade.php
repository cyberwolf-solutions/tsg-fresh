<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | TSG fresh Resort Waikkal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="TSG fresh Resort Waikkal" name="description" />
    <meta content="CyberWolf Solutions (Pvt) Ltd." name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 250px;
            --primary-color: #00A045;
            --sidebar-bg: #2c3e50;
            --sidebar-text: #ecf0f1;
            --sidebar-hover: #34495e;
            --content-bg: #f5f7fa;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: var(--content-bg);
        }

        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .admin-info {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-weight: bold;
        }

        .admin-details {
            display: flex;
            flex-direction: column;
        }

        .admin-name {
            font-weight: bold;
            font-size: 1.1rem;
        }

        .admin-role {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .sidebar-nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav li {
            margin-bottom: 5px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-nav a:hover {
            background-color: var(--sidebar-hover);
            padding-left: 25px;
        }

        .sidebar-nav i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .sidebar-nav .active {
            background-color: var(--primary-color);
        }

        .sidebar-footer {
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn {
            background: none;
            border: none;
            color: var(--sidebar-text);
            display: flex;
            align-items: center;
            width: 100%;
            padding: 10px;
            cursor: pointer;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .logout-btn:hover {
            color: #ff6b6b;
        }

        .logout-btn i {
            margin-right: 10px;
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
        }

        .page-header {
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="admin-info">
            <div class="admin-avatar">
                {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
            </div>
            <div class="admin-details">
                <span class="admin-name">{{ Auth::guard('admin')->user()->name }}</span>
                <span class="admin-role">Admin</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/branches*') ? 'active' : '' }}">
                    <a href="{{ route('admin.branches.index') }}">
                        <i class="fas fa-code-branch"></i>
                        <span>Branches</span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/web*') ? 'active' : '' }}">
                    <a href="{{ route('admin.web.settings') }}">
                        <i class="fas fa-globe"></i>
                        <span>Web</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    @stack('scripts')
</body>

</html>
