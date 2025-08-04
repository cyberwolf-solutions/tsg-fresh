<!-- ========== App Menu ========== -->

<div class="app-menu navbar-menu"
    style="position: fixed; top: 0; left: 0; height: 100vh; width: 250px; background: #F7F7F9; z-index: 1000;box-shadow: none !important;
border-right: none !important;">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ route('home') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('storage/' . $settings->logo_dark) }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ route('home') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('storage/' . $settings->logo_dark) }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar" style="padding-top: 60px;">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('home') }}">
                        <i class="ri-dashboard-2-line" style="color: purple"></i> <span
                            style="color: rgb(92, 92, 92)">Dashboard</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                {{-- product --}}
                @canany([
                    
                    'manage products',
                    'manage
                    categories',
                  
                    ])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#foods" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="foods">
                            <i class="mdi mdi-food-outline" style="color: purple"></i> <span>Product</span>
                        </a>
                        <div class="collapse menu-dropdown" id="foods">
                            <ul class="nav nav-sm flex-column">
                                {{-- @can('manage ingredients')
                                    <li class="nav-item">
                                        <a href="{{ route('ingredients.index') }}" class="nav-link">Ingredients</a>
                                    </li>
                                @endcan --}}
                                @can('manage products')
                                    <li class="nav-item">
                                        <a href="{{ route('products.index') }}" class="nav-link">Products</a>
                                    </li>
                                @endcan
                                 @can('manage categories')
                                    <li class="nav-item">
                                        <a href="{{ route('categories.index') }}" class="nav-link">Categories</a>
                                    </li>
                                @endcan
                             

                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- purchase  --}}
                @canany(['manage purchases'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#purchase" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="purchase">
                            <i class="ri-book-3-line" style="color: purple"></i> <span>Purchase</span>
                        </a>
                        <div class="collapse menu-dropdown" id="purchase">
                            <ul class="nav nav-sm flex-column">

                                @can('manage purchases')
                                    <li class="nav-item">
                                        <a href="{{ route('purchases.index') }}" class="nav-link">Ingredients Purchases</a>
                                    </li>
                                @endcan
                                @can('manage purchases')
                                    <li class="nav-item">
                                        <a href="{{ route('opurchases.index') }}" class="nav-link">Inventory Purchases</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- sale --}}
                @canany(['manage Inventory'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#inventory" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="inventory">
                            <i class="mdi mdi-food-outline" style="color: purple"></i> <span>Sale</span>
                        </a>
                        <div class="collapse menu-dropdown" id="inventory">
                            <ul class="nav nav-sm flex-column">
                                @can('manage Inventory')
                                    <li class="nav-item">
                                        <a href="{{ route('inventory.index') }}" class="nav-link">Item</a>
                                    </li>
                                @endcan
                                @can('manage Inventory')
                                    <li class="nav-item">
                                        <a href="{{ route('inventory.stock') }}" class="nav-link">Stock</a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcanany

                 {{-- order --}}
                @canany(['manage orders'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#order" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="order">
                            <i class="mdi mdi-food-outline" style="color: purple"></i> <span>Orders</span>
                        </a>
                        <div class="collapse menu-dropdown" id="order">
                            <ul class="nav nav-sm flex-column">
                                @can('manage orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.index') }}" class="nav-link">Orders</a>
                                    </li>
                                @endcan
                                {{-- @can('manage orders')
                                    <li class="nav-item">
                                        <a href="{{ route('inventory.stock') }}" class="nav-link">Stock</a>
                                    </li>
                                @endcan --}}

                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Expenses --}}
                @canany(['manage orders', 'manage kitchen', 'manage bar', 'manage tables', 'manage table-arrangements'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#exp" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="exp">
                           <i class="ri-wallet-3-line" style="color: purple;"></i> <span>Expenses</span>
                        </a>
                        <div class="collapse menu-dropdown" id="exp">
                            <ul class="nav nav-sm flex-column">
                                
                              
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Quatation --}}
                @canany(['manage orders', 'manage kitchen', 'manage bar', 'manage tables', 'manage table-arrangements'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#qua" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="qua">
                            <i class="ri-file-text-line" style="color: purple;"></i> <span>Quatation</span>
                        </a>
                        <div class="collapse menu-dropdown" id="qua">
                            <ul class="nav nav-sm flex-column">
                                
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Transfer --}}
                @canany(['manage orders', 'manage kitchen', 'manage bar', 'manage tables', 'manage table-arrangements'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#transfer" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="transfer">
                           <i class="ri-exchange-line" style="color: purple;"></i> <span>Transfer</span>
                        </a>
                        <div class="collapse menu-dropdown" id="transfer">
                            <ul class="nav nav-sm flex-column">
                              
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Return --}}
                @canany(['manage orders', 'manage kitchen', 'manage bar', 'manage tables', 'manage table-arrangements'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#return" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="return">
                          <i class="ri-arrow-go-back-line" style="color: purple;"></i> <span>Return</span>
                        </a>
                        <div class="collapse menu-dropdown" id="return">
                            <ul class="nav nav-sm flex-column">
                            
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Accounting --}}
                @canany(['manage orders', 'manage kitchen', 'manage bar', 'manage tables', 'manage table-arrangements'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#accounting" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="accounting">
                         <i class="ri-bar-chart-line" style="color: purple;"></i> <span>Accounting</span>
                        </a>
                        <div class="collapse menu-dropdown" id="accounting">
                            <ul class="nav nav-sm flex-column">
                           
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- HRM --}}
                @canany(['manage orders','manage employees'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#hrm" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="hrm">
                       <i class="ri-user-settings-line" style="color: purple;"></i> <span>HRM</span>
                        </a>
                        <div class="collapse menu-dropdown" id="hrm">
                            <ul class="nav nav-sm flex-column">
                                {{-- @can('manage orders')
                                    <li class="nav-item">
                                        <a href="{{ route('orders.index') }}" class="nav-link">Orders</a>
                                    </li>
                                @endcan --}}
                              
                                   @can('manage employees')
                                    <li class="nav-item">
                                        <a href="{{ route('employee-designations.index') }}" class="nav-link">Employee
                                            Designations</a>
                                    </li>
                                @endcan
                                @can('manage employees')
                                    <li class="nav-item">
                                        <a href="{{ route('employees.index') }}" class="nav-link">Employees</a>
                                    </li>
                                @endcan
                                {{-- @can('manage table arrangements')
                                    <li class="nav-item">
                                        <a href="{{ route('table-arrangements.index') }}" class="nav-link">Table
                                            Arrangements</a>
                                    </li>
                                @endcan --}}
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- peaple --}}
                @canany(['manage users',   'manage customers', 'manage suppliers'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#user" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="user">
                            <i class="ri-account-circle-line" style="color: purple"></i> <span>People</span>
                        </a>
                        <div class="collapse menu-dropdown" id="user">
                            <ul class="nav nav-sm flex-column">
                                @can('manage users')
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}" class="nav-link">Users</a>
                                    </li>
                                @endcan
                                 @can('manage customers')
                                    <li class="nav-item">
                                        <a href="{{ route('customers.index') }}" class="nav-link">Customers</a>
                                    </li>
                                @endcan
                                @can('manage suppliers')
                                    <li class="nav-item">
                                        <a href="{{ route('suppliers.index') }}" class="nav-link">Suppliers</a>
                                    </li>
                                @endcan
                                  @can('manage suppliers')
                                    <li class="nav-item">
                                        {{-- <a href="{{ route('biller.index') }}" class="nav-link">Biller</a> --}}
                                    </li>
                                @endcan
                        
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- pos --}}
                @canany(['manage Pos'])
                    <li class="nav-item">
                        @can('manage Pos')
                            <a class="nav-link menu-link" href="{{ route('restaurant.index') }}">
                                <i class="ri-menu-add-line" style="color: purple"></i> <span>POS</span>
                            </a>
                        @endcan
                    </li>
                @endcanany

                {{-- reports --}}
                @canany(['User report', 'Customer report', 'Supplier report', 'Purchase report', 'Employee report',
                    'Product report', 'Booking report'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#report" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="report">
                            <i class="ri-book-3-line" style="color: purple"></i> <span>Reports</span>
                        </a>
                        <div class="collapse menu-dropdown" id="report">
                            <ul class="nav nav-sm flex-column">
                                {{-- @can('User report')
                                    <li class="nav-item">
                                        <a href="{{ route('users.ReportsIndex') }}" class="nav-link">User Report</a>
                                    </li>
                                @endcan --}}
                                @can('Customer report')
                                    <li class="nav-item">
                                        <a href="{{ route('customers.ReportsIndex') }}" class="nav-link">Guest Reports</a>
                                    </li>
                                @endcan
                                {{-- @can('Employee report')
                                    <li class="nav-item">
                                        <a href="{{ route('employees.ReportsIndex') }}" class="nav-link">Employees
                                            Reports</a>
                                    </li>
                                @endcan --}}
                                @can('Supplier report')
                                    <li class="nav-item">
                                        <a href="{{ route('supplier.ReportsIndex') }}" class="nav-link">Supplier Reports</a>
                                    </li>
                                @endcan
                                @can('Purchase report')
                                    <li class="nav-item">
                                        <a href="{{ route('purchase.ReportsIndex') }}" class="nav-link">Purchase Reports</a>
                                    </li>
                                @endcan
                                @can('Purchase report')
                                    <li class="nav-item">
                                        <a href="{{ route('opurchase.ReportsIndex') }}" class="nav-link">Inventory Purchase
                                            Reports</a>
                                    </li>
                                @endcan
                                @can('Product report')
                                    <li class="nav-item">
                                        <a href="{{ route('product.ReportsIndex') }}" class="nav-link">Product Reports</a>
                                    </li>
                                @endcan
                               
                             



                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- SETTINGS --}}
                 @canany(['manage settings', 'manage modifiers', 'manage categories', 'manage units','manage roles'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#settings" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="settings">
                            <i class="ri-settings-2-line" style="color: purple"></i> <span>Settings</span>
                        </a>


                        <div class="collapse menu-dropdown" id="settings">
                            <ul class="nav nav-sm flex-column">
                                @can('manage users')
                                    <li class="nav-item">
                                        <a href="{{ route('settings.index') }}" class="nav-link">General</a>
                                    </li>
                                @endcan
                                @can('manage roles')
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">Roles</a>
                                    </li>
                                @endcan
                           

                              
                                @can('manage units')
                                    <li class="nav-item">
                                        <a href="{{ route('units.index') }}" class="nav-link">Units</a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcanany
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
