<?php

declare(strict_types=1);

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
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MealsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TablesController;
use Stancl\Tenancy\Database\Models\Domain;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SetMenuController;
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
use App\Http\Controllers\CheckinCheckoutController;
use App\Http\Controllers\AdditionalPaymentController;
use App\Http\Controllers\TableArrangementsController;
use App\Http\Controllers\EmployeeDesignationsController;
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



    Route::get('/force-tenant', function () {
        $tenant = \App\Models\Tenant::find('jaffna');

        if ($tenant) {
            tenancy()->initialize($tenant);
            return "Initialized tenant: " . tenant('id') .
                " | DB: " . DB::connection()->getDatabaseName();
        }

        return "Tenant not found";
    });

    Route::middleware(['guest'])->group(function () {
        Route::get('/', function () {
         return view('pos.auth.login');
        })->name('login');
    });
    Auth::routes();

    Route::middleware(['auth'])->group(function () {
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
        Route::resource('units', UnitController::class)->middleware('can:manage units');
        Route::resource('ingredients', IngredientsController::class)->middleware('can:manage ingredients');
        Route::resource('products', ProductController::class)->middleware('can:manage products');
        Route::resource('meals', MealsController::class)->middleware('can:manage meals');
        Route::resource('modifiers', ModifiersController::class)->middleware('can:manage modifiers');
        Route::resource('restaurant', RestaurantController::class)->middleware('can:manage Pos');
        // Route::resource('restaurant', RestaurantController::class);
        Route::get('/restaurant-note', [RestaurantController::class, 'note'])->name('restaurant.note');
        Route::get('/restaurant-in-process', [RestaurantController::class, 'process'])->name('restaurant.process');
        Route::get('/restaurant-tables', [RestaurantController::class, 'tables'])->name('restaurant.tables');
        Route::get('/restaurant-rooms', [RestaurantController::class, 'rooms'])->name('restaurant.rooms');
        Route::get('/restaurant-customer', [RestaurantController::class, 'customer'])->name('restaurant.customer');
        Route::get('/restaurant-customer-add', [RestaurantController::class, 'customerAdd'])->name('restaurant.customer-add');
        Route::get('/restaurant-discount', [RestaurantController::class, 'discount'])->name('restaurant.discount');
        Route::get('/restaurant-vat', [RestaurantController::class, 'vat'])->name('restaurant.vat');
        Route::get('/restaurant-modifiers', [RestaurantController::class, 'modifiers'])->name('restaurant.modifiers');
        Route::post('/restaurant/checkout', [RestaurantController::class, 'checkout'])->name('restaurant.checkout');
        Route::resource('kitchen', KitchenController::class)->middleware('can:manage kitchen');
        Route::resource('bar', BarController::class)->middleware('can:manage bar');
        Route::resource('tables', TablesController::class)->middleware('can:manage tables');
        Route::resource('table-arrangements', TableArrangementsController::class)->middleware('can:manage table-arrangements');
        Route::resource('orders', OrderController::class)->middleware('can:manage orders');
        Route::get('order/print/{id}', [OrderController::class, 'print'])->middleware('can:manage orders')->name('order.print');
        Route::get('kot/print/{id}', [KitchenController::class, 'print'])->name('kot.print');
        Route::get('bot/print/{id}', [BarController::class, 'print'])->name('bot.print');
        Route::resource('rooms', RoomController::class)->middleware('can:manage rooms');
        Route::resource('room-types', RoomTypesController::class)->middleware('can:manage rooms');
        Route::resource('bookings', BookingController::class)->middleware('can:manage bookings');
        Route::get('get-ingredients', [IngredientsController::class, 'getIngredients'])->name('get-ingredients');
        Route::get('get-product-ingredients', [IngredientsController::class, 'getProductIngredients'])->name('get-product-ingredients');
        Route::get('get-products', [ProductController::class, 'getProducts'])->name('get-products');
        Route::get('get-meal-products', [ProductController::class, 'getMealProducts'])->name('get-meal-products');
        Route::get('get-modifier-categories', [CategoryController::class, 'getModifierCategories'])->name('get-modifier-categories');
        Route::get('get-modifier-ingredients', [IngredientsController::class, 'getModifierIngredients'])->name('get-modifier-ingredients');
        Route::get('get-booking-customers', [BookingController::class, 'getBookingCustomers'])->name('get-booking-customers');
        Route::get('get-booking-rooms', [BookingController::class, 'getBookingRooms'])->name('get-booking-rooms');

        Route::get('check-availability', [BookingController::class, 'checkAvailability'])->name('check-availability')->middleware('can:manage bookings');
        Route::get('get-available-rooms', [BookingController::class, 'getAvailableRooms'])->name('get-available-rooms');
        Route::get('get-booking-customers', [BookingController::class, 'getBookingCustomers'])->name('get-booking-customers');
        Route::post('complete-meal', [RestaurantController::class, 'completeMeal'])->name('complete-meal');
        Route::post('order/complete', [RestaurantController::class, 'completeOrder'])->name('order.complete');
        Route::get('status', [BookingController::class, 'status'])->name('status')->middleware('can:manage bookings');
        Route::resource('opurchases', OtherPurchaseController::class)->middleware('can:manage purchases');
        Route::get('/opurchase-payment/{id}', [OtherPurchaseController::class, 'viewAddPayment'])->name('opurchases.payment');
        Route::post('/opurchase-payment', [OtherPurchaseController::class, 'addPayment'])->name('opurchases.payment.add');
        Route::get('/opurchase-payments/view/{id}', [OtherPurchaseController::class, 'viewPayments'])->name('opurchases.payments.view');

        Route::get('/inventory/stock', [InventoryController::class, 'stock'])->name('inventory.stock');
        Route::resource('inventory', InventoryController::class)->middleware('can:manage Inventory');

        Route::get('/housekeeping/view', [HouseKeepingCOntroller::class, 'view'])->name('housekeeping.view');
        Route::resource('housekeeping', HouseKeepingCOntroller::class)->middleware('can:manage housekeeping');
        // Route::get('/housekeeping/hostory', [HouseKeepingCOntroller::class, 'view'])->name('housekeeping.view');

        //user profile
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/profile', [UserController::class, 'profileUpdate'])->name('profile.update');
        Route::post('/profile-image-update', [UserController::class, 'imageUpdate'])->name('image.update');
        Route::post('/profile-cover-update', [UserController::class, 'coverUpdate'])->name('cover.update');
        Route::post('/password-change', [UserController::class, 'passwordUpdate'])->name('password.change');

        //room size
        Route::resource('room-size', RoomSizeController::class)->middleware('can:manage rooms');
        Route::resource('room-facility', RoomFacilityController::class)->middleware('can:manage rooms');
        Route::resource('checkin', CheckinCheckoutController::class)->middleware('can:manage bookings');

        // routes/web.php
        Route::get('/get-booking-rooms/{customerId}', [CheckinCheckoutController::class, 'getBookingRooms'])->name('get.booking.rooms');
        // Route::get('/get-checkout-rooms/{customerId}', [CheckinCheckoutController::class, 'getcheckoutRooms'])->name('get.checkout.rooms');
        Route::get('/get-checkout-rooms/{customerId}', [CheckinCheckoutController::class, 'getcheckoutRooms'])->name('get.checkout.rooms');
        Route::get('/get-room-facility/{facilityId}', [CheckinCheckoutController::class, 'getRoomFacility'])->name('get-room-facility');

        Route::resource('checkout', CheckoutController::class)->middleware('can:manage bookings');
        Route::resource('tacheckout', TACheckoutController::class)->middleware('can:manage bookings');
        Route::get('/get-booking-payment-details/{bookingId}', [CheckoutController::class, 'getBookingPaymentDetails']);

        Route::get('/get-customer-orders/{customerId}', [CheckoutController::class, 'getCustomerOrders']);
        Route::get('/get-checkincheckout-id',  [CheckoutController::class, 'getCheckinCheckoutId'])->name('get.checkincheckout.id');

        Route::get('/checkout/invoice/{checkincheckout_id}', [CheckoutController::class, 'invoice'])->name('checkout.invoice');
        Route::get('/checkout/additional/invoice/{customer_id}/{checkout_date}', [CheckoutController::class, 'additionalInvoice'])->name('checkout.additional.invoice');
        Route::get('/checkout/additionalservice/invoice/{customer_id}/{checkout_date}', [CheckoutController::class, 'additionalServiceInvoice'])->name('checkout.additionalService.invoice');

        Route::get('/rooms/filter', [RoomController::class, 'filter'])->name('rooms.filter');
        Route::post('/rooms/filterByStatus', [BookingController::class, 'filterByStatus'])->name('rooms.filterByStatus');

        Route::post('/update-booking-cancel-reason/{id}', [BookingController::class, 'updateCancelReason'])->name('update.booking.cancel.reason');

        //additional payments
        Route::resource('additional-payments', AdditionalPaymentController::class)->middleware('can:manage bookings');

        //bording type
        Route::resource('bording-type', BordingTypeCOntroller::class)->middleware('can:manage bording');


        Route::post('/send-ebill', [EmailController::class, 'sendEbill'])->name('send-ebill');

        //setmenu
        Route::resource('setmenu', SetMenuController::class)->middleware('can:manage meals');
        Route::resource('setmenumeal', SetMenuMealController::class)->middleware('can:manage categories');
        //filter setmenu
        Route::get('/restaurant-setmenu', [RestaurantController::class, 'filterSetMenus'])
            ->name('restaurant.filter_setmenus');



        Route::post('/bookings/update-dates', [BookingController::class, 'updateDates'])->name('bookings.updateDates');
    });
});
