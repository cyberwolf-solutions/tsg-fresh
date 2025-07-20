<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Ingredient;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {


        $totalOrders = Order::all()->count();
        $totalBookings = Booking::all()->count();

        // Get today's date
        $todayDate = Carbon::now()->toDateString();

        // Get today's orders 
        $todayOrders = Order::whereDate('created_at', $todayDate)->get();

        // Get today's bookings 
        $todayBookings = Booking::whereDate('created_at', $todayDate)->get();
        // dd($todayBookings);

        $customers = Customer::all();

        $employees = Employee::all();

        $suppliers = Supplier::all();

        $Products = Ingredient::orderBy('quantity')->get();

        $Products1 = Inventory::orderBy('quantity')->get();


     return view('pos.home', compact('totalOrders', 'totalBookings', 'todayOrders', 'todayBookings' ,'customers' , 'employees' ,'suppliers' , 'Products' ,'Products1'));
    }
}
