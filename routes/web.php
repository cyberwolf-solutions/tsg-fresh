<?php

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


foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {

         return view('admin.branches.index');

        });

        Route::get('/branches', [BranchController::class, 'index']);

        Route::post('/branches/store', [BranchController::class, 'store'])->name('branches.store');


        Route::get('/landing', function () {

         return view('landing-page.home');

        });
        // Route::get('/abountus', [App\Http\Controllers\LandingPageController::class, 'aboutus'])->name('landing.about');

        Route::get('/about', function () {

            return view('Landing-page.about');
        });
        Route::get('/shop-now', function () {
            return view('Landing-page.shop-now');
        });

        Route::get('/dynamic-page', function () {
            return view('Landing-page.dynamic');
        });

        Route::get('/contact', function () {
            return view('Landing-page.contact');

         return view('Landing-page.about');
        });

        Route::get('/contact', function () {
         return view('Landing-page.contact');

        });
    });
}
