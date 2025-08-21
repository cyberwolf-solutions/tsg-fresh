<?php

declare(strict_types=1);


use App\Http\Controllers\CashInHandController;
use App\Models\Tenant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BillerController;
use App\Http\Controllers\TablesController;
use Stancl\Tenancy\Database\Models\Domain;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SetMenuController;
use App\Http\Controllers\ShopNowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RoomSizeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ModifiersController;
use App\Http\Controllers\RoomTypesController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TACheckoutController;
use App\Http\Controllers\BordingTypeCOntroller;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\SetMenuMealController;
use App\Http\Controllers\HouseKeepingCOntroller;
use App\Http\Controllers\RoomFacilityController;
use App\Http\Controllers\OtherPurchaseController;
use App\Http\Controllers\SingelProductController;
use App\Http\Controllers\CheckinCheckoutController;
use App\Http\Controllers\AdditionalPaymentController;

use App\Http\Controllers\CouponController;

use App\Http\Controllers\CartController;

use App\Http\Controllers\TableArrangementsController;
use App\Http\Controllers\EmployeeDesignationsController;
use App\Http\Controllers\HomeController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::get('/debug-domains', function () {
        return Domain::all();
    });

    Route::get('/debug-tenant-db', function () {
        $tenant = tenancy()->tenant;
        if ($tenant) {
            $dbName = $tenant->getDatabaseName();
            $config = DB::connection('tenant')->getConfig();
            return [
                'tenant_id' => $tenant->id,
                'database_name' => $dbName,
                'connection_config' => $config,
                'connection_database' => DB::connection('tenant')->getDatabaseName(),
            ];
        }
        return 'No tenant initialized';
    })->middleware(['web', InitializeTenancyByDomain::class, PreventAccessFromCentralDomains::class]);

    Route::get('/test-db', function () {
        try {
            // Get the current tenant
            $tenant = tenancy()->tenant;
            $tenantId = $tenant ? $tenant->id : 'No tenant resolved';

            // Get the tenant connection
            $connection = DB::connection('tenant')->getConfig();
            $loggable = Arr::only(
                $connection,
                ['driver', 'host', 'port', 'database', 'username', 'charset', 'collation', 'prefix']
            );

            Log::info('Database connection test', [
                'tenant_id' => $tenantId,
                'connection' => $loggable,
            ]);

            return 'Connected to: ' . ($loggable['database'] ?? 'unknown') . ' (Tenant: ' . $tenantId . ')';
        } catch (\Throwable $e) {
            Log::error('Database connection failed', [
                'error' => $e->getMessage(),
                'tenant_id' => tenancy()->tenant->id ?? 'No tenant resolved',
                'driver' => DB::connection()->getConfig()['driver'] ?? null,
                'database' => DB::connection()->getConfig()['database'] ?? null,
            ]);

            return 'Failed to connect: ' . $e->getMessage();
        }
    });

    Route::get('/test', function () {
        if (tenancy()->tenant) {
            Log::info("✅ Tenant resolved: " . tenancy()->tenant->id);
            return [
                'tenant_id' => tenancy()->tenant->id,
                'db' => DB::connection('tenant')->getDatabaseName()
            ];
        } else {
            Log::error("❌ No tenant resolved!");
            return response()->json(['error' => 'Tenant not found'], 500);
        }
    });

    Route::get('/check-tenants', function () {
        return Tenant::all()->toArray();
    });

        Route::get('invoice/print/{id}', [OrderController::class, 'invoice'])->name('invoice.print');


    Route::get('/force-tenant', function () {
        $tenant = \App\Models\Tenant::find('jaffna');

        if ($tenant) {
            tenancy()->initialize($tenant);
            return "Initialized tenant: " . tenant('id') .
                " | DB: " . DB::connection()->getDatabaseName();
        }

        return "Tenant not found";
    });



    Route::get('/shop-now', [ShopNowController::class, 'product'])->name('shopnow.product');
    Route::get('/single/{product}', [SingelProductController::class, 'index'])->name('single.index');

    Route::get('/shop-now', [ShopNowController::class, 'product'])->name('shopnow.product');

    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
        ->name('checkout.success');


    Route::get('/single/{product}', [SingelProductController::class, 'index'])->name('single.index');


    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // routes/web.php
    Route::get('/footer-data', [HomeController::class, 'footerData']);


    Route::middleware(['guest'])->group(function () {
        Route::get('/', function () {

            return view('auth.login');
        })->name('login');
    });
    Auth::routes();
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/sidebar', [CartController::class, 'sidebar'])->name('cart.sidebar');
    Route::get('/cart/page', [CartController::class, 'sidebar1'])->name('cart.sidebar1');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::get('/weborder-view', [OrderController::class, 'web'])->name('orders.web');
    Route::get('/instoreorder-view', [OrderController::class, 'instore'])->name('orders.instore');

    Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('web.checkout.place');

    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])
        ->name('coupon.apply');
    // Checkout success page
    // Route::get('/checkout/success/{order}', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::post('/cart/update/{item}', [CartController::class, 'updateQuantity'])->name('cart.update');

    Route::middleware(['auth'])->group(function () {
        Route::get('/customers/search', [App\Http\Controllers\CustomerController::class, 'search'])
            ->name('customers.search');
        Route::get('/products/search', [App\Http\Controllers\ProductController::class, 'search'])
            ->name('products.search');

        //reports
        Route::get('/user', [ReportsController::class, 'user'])->name('users.ReportsIndex')->middleware('can:User report');
        Route::get('/customer', [ReportsController::class, 'customer'])->name('customers.ReportsIndex')->middleware('can:Customer report');
        Route::get('/employee', [ReportsController::class, 'employee'])->name('employees.ReportsIndex')->middleware('can:Employee report');
        Route::get('/supplier', [ReportsController::class, 'supplier'])->name('supplier.ReportsIndex')->middleware('can:Supplier report');
        Route::get('/purchase', [ReportsController::class, 'purchase'])->name('purchase.ReportsIndex')->middleware('can:Purchase report');
        Route::get('/product', [ReportsController::class, 'product'])->name('product.ReportsIndex')->middleware('can:Product report');
        Route::get('/booking', [ReportsController::class, 'reservation'])->name('booking.ReportsIndex')->middleware('can:Booking report');
        Route::get('/Opurchase', [ReportsController::class, 'opurchase'])->name('opurchase.ReportsIndex')->middleware('can:Purchase report');
        Route::get('/report', [ReportsController::class, 'all'])->name('all.ReportsIndex')->middleware('can:Booking report');
        Route::get('/orders/reports', [ReportsController::class, 'orders'])->name('orders.Reports')->middleware('can:Booking report');
        Route::get('/booking1', [ReportsController::class, 'booking'])->name('booking.ReportsIndex1')->middleware('can:Booking report');
        Route::get('/tareports', [ReportsController::class, 'ta'])->name('TaReport')->middleware('can:Booking report');
        Route::get('/coupon', [CouponController::class, 'index'])->name('coupon.index');
        Route::get('/coupon-create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/coupon-store', [CouponController::class, 'store'])->name('coupons.store');
        Route::post('/coupon-update', [CouponController::class, 'update'])->name('coupon.update');
        Route::post('/coupons/apply', [CouponController::class, 'apply'])->name('coupons.apply');
        Route::get('/orders/recent', [RestaurantController::class, 'recentOrders'])->name('orders.recent');

        Route::prefix('cash')->group(function () {
            Route::get('modal', [CashInHandController::class, 'openModal'])->name('cash.modal');
            Route::post('save', [CashInHandController::class, 'save'])->name('cash.save');
            Route::get('show', [CashInHandController::class, 'show'])->name('cashinhand');
        });


        Route::post('/orders/payments/store', [OrderController::class, 'payment'])->name('orders.payments.store');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::post('/change/mode', [UserController::class, 'changeMode'])->name('change.mode');
        Route::resource('settings', SettingsController::class)->middleware('can:manage settings');
        Route::resource('users', UserController::class)->middleware('can:manage users');
        Route::post('/change-status', [UserController::class, 'status'])->name('users.status');
        Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        Route::resource('roles', RoleController::class)->middleware('can:manage roles');
        Route::post('/update-settings', [SettingsController::class, 'updateSettings'])->name('update-settings');
        Route::post('/update-mail', [SettingsController::class, 'updateMail'])->name('update-mail');
        Route::resource('employees', EmployeeController::class)->middleware('can:manage employees');
        Route::resource('employee-designations', EmployeeDesignationsController::class)->middleware('can:manage employees');
        Route::resource('customers', CustomerController::class)->middleware('can:manage customers');
        Route::resource('suppliers', SupplierController::class)->middleware('can:manage suppliers');
        Route::resource('purchases', PurchaseController::class)->middleware('can:manage purchases');
        Route::get('/purchase-payment/{id}', [PurchaseController::class, 'viewAddPayment'])->name('purchases.payment');
        Route::post('/purchase-payment', [PurchaseController::class, 'addPayment'])->name('purchases.payment.add');
        Route::get('/purchase-payments/view/{id}', [PurchaseController::class, 'viewPayments'])->name('purchases.payments.view');
        Route::resource('categories', CategoryController::class)->middleware('can:manage categories');
        Route::resource('brand', BrandController::class)->middleware('can:manage categories');
        Route::resource('units', UnitController::class)->middleware('can:manage units');
        Route::resource('ingredients', IngredientsController::class)->middleware('can:manage ingredients');
        Route::resource('products', ProductController::class)->middleware('can:manage products');
        Route::resource('restaurant', RestaurantController::class)->middleware('can:manage Pos');
        Route::get('/restaurant-note', [RestaurantController::class, 'note'])->name('restaurant.note');
        Route::get('/restaurant-in-process', [RestaurantController::class, 'process'])->name('restaurant.process');
        Route::get('/restaurant-tables', [RestaurantController::class, 'tables'])->name('restaurant.tables');
        Route::get('/restaurant-rooms', [RestaurantController::class, 'rooms'])->name('restaurant.rooms');
        Route::get('/restaurant-customer', [RestaurantController::class, 'customer'])->name('restaurant.customer');
        Route::get('/restaurant-customer-add', [RestaurantController::class, 'customerAdd'])->name('restaurant.customer-add');
        // Route::get('/customers/search', [App\Http\Controllers\CustomerController::class, 'search'])->name('customers.search');

        Route::get('/restaurant-discount', [RestaurantController::class, 'discount'])->name('restaurant.discount');
        Route::get('/restaurant-vat', [RestaurantController::class, 'vat'])->name('restaurant.vat');
        Route::get('/restaurant-modifiers', [RestaurantController::class, 'modifiers'])->name('restaurant.modifiers');
        Route::post('/restaurant/checkout', [RestaurantController::class, 'checkout'])->name('restaurant.checkout');
        Route::resource('orders', OrderController::class)->middleware('can:manage orders');
        Route::get('order/print/{id}', [OrderController::class, 'print'])->middleware('can:manage orders')->name('order.print');
        Route::get('order/printtax/{id}', [OrderController::class, 'printtax'])->middleware('can:manage orders')->name('ordertax.print');
        Route::get('order/show/{id}', [OrderController::class, 'show'])->middleware('can:manage orders')->name('orders.show');
        Route::get('get-ingredients', [IngredientsController::class, 'getIngredients'])->name('get-ingredients');
        Route::get('get-product-ingredients', [IngredientsController::class, 'getProductIngredients'])->name('get-product-ingredients');
        Route::get('get-products', [ProductController::class, 'getProducts'])->name('get-products');
        Route::get('get-meal-products', [ProductController::class, 'getMealProducts'])->name('get-meal-products');
        Route::get('get-modifier-categories', [CategoryController::class, 'getModifierCategories'])->name('get-modifier-categories');
        Route::get('get-modifier-ingredients', [IngredientsController::class, 'getModifierIngredients'])->name('get-modifier-ingredients');
        Route::post('complete-meal', [RestaurantController::class, 'completeMeal'])->name('complete-meal');
        Route::post('order/complete', [RestaurantController::class, 'completeOrder'])->name('order.complete');
        Route::resource('opurchases', OtherPurchaseController::class)->middleware('can:manage purchases');
        Route::get('/opurchase-payment/{id}', [OtherPurchaseController::class, 'viewAddPayment'])->name('opurchases.payment');
        Route::post('/opurchase-payment', [OtherPurchaseController::class, 'addPayment'])->name('opurchases.payment.add');
        Route::get('/opurchase-payments/view/{id}', [OtherPurchaseController::class, 'viewPayments'])->name('opurchases.payments.view');
        Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        Route::get('/inventory/stock', [InventoryController::class, 'stock'])->name('inventory.stock');
        Route::resource('inventory', InventoryController::class)->middleware('can:manage Inventory');

        Route::get('/get-variants/{product}', [ProductController::class, 'getVariants']);


        //user profile
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');
        Route::post('/profile-image-update', [UserController::class, 'imageUpdate'])->name('image.update');
        Route::post('/profile-cover-update', [UserController::class, 'coverUpdate'])->name('cover.update');
        Route::post('/password-change', [UserController::class, 'passwordUpdate'])->name('password.change');
        Route::resource('additional-payments', AdditionalPaymentController::class)->middleware('can:manage bookings');
        Route::post('/send-ebill', [EmailController::class, 'sendEbill'])->name('send-ebill');
        Route::get('/restaurant-setmenu', [RestaurantController::class, 'filterSetMenus'])
            ->name('restaurant.filter_setmenus');



        // Route::G('/biller', [BillerController::class, 'index'])->name('biller.index');
    });
});
