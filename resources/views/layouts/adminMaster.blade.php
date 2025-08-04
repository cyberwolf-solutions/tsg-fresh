<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-layout-style="detached"
    data-sidebar="{{ $mode }}" data-topbar="dark" data-sidebar-size="lg" data-bs-theme="{{ $mode }}"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title') | TSG fresh Resort Waikkal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="TSG fresh  Resort Waikkal" name="description" />
    <meta content="CyberWolf Solutions (Pvt) Ltd." name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <!-- Toastr JS (after jQuery) -->



    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico') }}">
    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
<!-- Begin page -->
<div id="loader" class="position-absolute d-none"
    style="z-index: 9999;top:0;left:0;user-select: none;background-color:#0000007b;width:100vmax;height:100%;display: flex;
justify-content: center;
align-items: center;">
    @include('layouts.loader')
</div>
<div id="layout-wrapper">
    {{-- @include('layouts.topbar')
    @include('layouts.sidebar') --}}
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        @include('layouts.footer')
    </div>
    <!-- end main content-->
</div>
<!-- END layout-wrapper -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="showCanvas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">More</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="body">
    </div>
</div>
<div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="body">
            </div>
        </div>
    </div>
</div>
<!-- JAVASCRIPT -->
{{-- @include('layouts.vendor-scripts') --}}
</body>

</html>
