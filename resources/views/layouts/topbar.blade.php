<header id="page-topbar" style="background-color: #ffffff;border:none">

    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo" style="background-color: #ffffff;">
                    <a href="{{ route('home') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        {{-- <span class="logo-lg">
                            <img src="{{ URL::asset('app/public/storage/' . $settings->logo_dark) }}" alt=""
                                height="47">
                        </span> --}}
                    </a>

                    <a href="{{ route('home') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        {{-- <span class="logo-lg">
                            <img src="{{ URL::asset('public/storage/' . $settings->logo_light) }}" alt=""
                                height="47">
                        </span> --}}
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon" style="background-color: #ffffff;">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>


            </div>

            <div class="d-flex align-items-center">

                {{-- <div class="ms-1 header-item d-none d-sm-flex" style="background-color: #ffffff;">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div> --}}

                <!-- POS Button -->
                <div class="ms-3 d-none d-sm-flex">
                    <a href="" class="btn btn-purple btn-sm px-3 fw-bold">POS</a>
                </div>

                <!-- Cart Icon -->
                <div class="ms-2 header-item d-none d-sm-flex">
                    <a href="" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        style=" color: #6f42c1; border: none;">
                        <i class="ri-shopping-cart-2-line fs-22"></i>
                    </a>
                </div>

                <!-- Notification Icon -->
                <div class="dropdown ms-2 d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        style=" color: #6f42c1;  border: none;" id="notificationDropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="ri-notification-3-line fs-22"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="notificationDropdown">
                        <div class="p-3 border-bottom">
                            <h6 class="mb-0">Notifications</h6>
                        </div>
                        <div style="max-height: 200px; overflow-y: auto;">
                            <a href="#" class="dropdown-item d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">New order placed</h6>
                                    <p class="text-muted mb-0 small">You have 1 new order</p>
                                </div>
                            </a>
                            <!-- Add more notifications here -->
                        </div>
                        <div class="p-2 border-top text-center">
                            <a href="" class="btn btn-sm btn-light w-100">View All</a>
                        </div>
                    </div>
                </div>

                <!-- Language Dropdown -->
                <div class="dropdown ms-2 d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        style=" color: #6f42c1; border: none;" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ri-global-line fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="?lang=en" class="dropdown-item">🇬🇧 English</a>
                        <a href="?lang=si" class="dropdown-item">🇱🇰 Sinhala</a>
                        <a href="?lang=ta" class="dropdown-item">🇮🇳 Tamil</a>
                    </div>
                </div>

                <div class="dropdown ms-sm-3 header-item topbar-user" style="background-color: #ffffff;">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="@if (Auth::user()->avatar != '') {{ URL::asset('public/storage/' . Auth::user()->avatar) }}@else{{ URL::asset('build/images/users/user-dummy-img.jpg') }} @endif"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-semibold user-name-text"
                                    style="color:black">{{ Auth::user()->name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-13 user-name-sub-text">{{ Auth::user()->roles()->first()->name }}</span>
                            </span>
                        </span>
                    </button>



                    <div class="dropdown-menu dropdown-menu-end" style="background-color: white">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('profile') }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="{{ route('settings.index') }}"><i
                                class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Settings</span></a>
                        <a class="dropdown-item " href="javascript:void();"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                class="bx bx-power-off font-size-16 align-middle me-1"></i> <span
                                key="t-logout">@lang('translation.logout')</span></a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                        It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
