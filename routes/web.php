<?php

use Stancl\Tenancy\Facades\Tenancy;
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
use App\Http\Controllers\BranchController;
use App\Http\Controllers\TablesController;
use Stancl\Tenancy\Database\Models\Tenant;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SetMenuController;
use App\Http\Controllers\ShopNowController;
use App\Http\Controllers\web\WebController;
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
use App\Http\Controllers\BankDetailController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TACheckoutController;
use App\Http\Controllers\BordingTypeCOntroller;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\SetMenuMealController;
use App\Http\Controllers\HouseKeepingCOntroller;
use App\Http\Controllers\RoomFacilityController;
use App\Http\Controllers\OtherPurchaseController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\DeliveryChargeController;
use App\Http\Controllers\CheckinCheckoutController;
use App\Http\Controllers\WebCustomerAuthController;
use App\Http\Controllers\customer\AccountController;
use App\Http\Controllers\AdditionalPaymentController;
use App\Http\Controllers\AdminReview;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\TableArrangementsController;
use App\Http\Controllers\EmployeeDesignationsController;

Route::group(['middleware' => ['web']], function () {
    Route::post('webcustomer/register', [WebCustomerAuthController::class, 'register'])
        ->name('customer.register.post');
    Route::post('webcustomer/login', [WebCustomerAuthController::class, 'login'])
        ->name('customer.login.post');

    Route::get('webcustomer/dashboard', [\App\Http\Controllers\customer\CustomerController::class, 'index'])
        ->name('customer.dashboard');
    Route::get('webcustomer/account', [\App\Http\Controllers\customer\AccountController::class, 'index'])
        ->name('customer.account');
    Route::get('webcustomer/address', [\App\Http\Controllers\customer\AccountController::class, 'address'])
        ->name('customer.address');
    Route::get('webcustomer/address-create', [\App\Http\Controllers\customer\AccountController::class, 'create'])
        ->name('customer.address.create');


    Route::put('/account', [AccountController::class, 'update'])->name('customer.account.update');
    Route::post('/address', [AccountController::class, 'storeAddress'])->name('customer.address.store');

    Route::post('/web-logout', [WebCustomerAuthController::class, 'logout'])->name('customer.logout');

    Route::get('/webcustomer/orders', [CustomerOrderController::class, 'index'])
        ->name('customer.order.index');
});

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {

            return view('admin.login');
        });

        // Public routes (no auth required)
        Route::prefix('admin')->group(function () {
            Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
            Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
        });


        Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
            Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
            Route::get('/branches', [BranchController::class, 'index'])
                ->name('admin.branches.index');

            Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
            Route::get('/branches', [BranchController::class, 'index'])->name('admin.branches.index');
            Route::get('/review', [AdminReview::class, 'index'])->name('admin.review.index');
            Route::get('/web/settings', [WebController::class, 'settings'])->name('admin.web.settings');
            Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
            Route::post('/admin/reviews/{tenant}/{review}/approve', [AdminReview::class, 'approve'])->name('admin.reviews.approve');
            Route::delete('/admin/reviews/{tenant}/{review}', [AdminReview::class, 'destroy'])->name('admin.reviews.destroy');


            Route::post('/items', [WebController::class, 'storeItem'])->name('store-item');
            Route::put('/items/{item}', [WebController::class, 'updateItem'])->name('update-item');
            Route::delete('/items/{item}', [WebController::class, 'deleteItem'])->name('delete-item');


            Route::get('/delivery-charges', [DeliveryChargeController::class, 'index'])->name('delivery-charges.index');
            Route::post('/delivery-charges', [DeliveryChargeController::class, 'store'])->name('delivery-charges.store');
            Route::delete('/delivery-charges/{id}', [DeliveryChargeController::class, 'destroy'])->name('delivery-charges.destroy');

            Route::get('/bank-details', [BankDetailController::class, 'index'])->name('bank-details.index');
            Route::post('/bank-details', [BankDetailController::class, 'store'])->name('bank-details.store');
            Route::delete('/bank-details/{id}', [BankDetailController::class, 'destroy'])->name('bank-details.destroy');
        });

        // Route::post('webcustomer/register', [WebCustomerAuthController::class, 'register'])->name('customer.register.post');


        // tenet
        // Route::get('/select-branch/{branch}', function ($branch) {
        //     $tenant = Tenant::find($branch); // or `where('id', $branch)->first()`

        //     if (! $tenant) {
        //         abort(404, 'Branch not found');
        //     }

        //     $domain = $tenant->domains()->first()->domain;

        //     return redirect()->away("http://{$domain}/store");
        // })->name('select.branch');

        Route::get('/select-branch/{branch}', [ShopNowController::class, 'index'])->name('select.branch');

        Route::get('/branches', [BranchController::class, 'index']);

        Route::post('/branches/store', [BranchController::class, 'store'])->name('branches.store');


        Route::get('/landing', [LandingController::class, 'index']);
        // Route::get('/landing', function () {

        //     return view('landing-page.home');
        // });
        // Route::get('/abountus', [App\Http\Controllers\LandingPageController::class, 'aboutus'])->name('landing.about');

        Route::get('/about', function () {

            return view('Landing-page.about');
        });
        Route::get('/shop-now', function () {
            return view('Landing-page.shop-now');
        })->name('Landing-page.shop-now');

        Route::get('/dynamic-page', function () {
            return view('Landing-page.dynamic');
        });

        // Route::get('/single', function () {
        //     return view('Landing-page.singleView');
        // });


        Route::get('/cart', function () {
            return view('Landing-page.cart');
        });


        Route::get('/checkout', function () {
            return view('Landing-page.checkout');
        });

        Route::get('/contact', function () {
            return view('Landing-page.contact');
        });
    });
}
