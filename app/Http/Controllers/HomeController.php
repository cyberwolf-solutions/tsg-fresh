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


        // Labels for cash flow by month or date
$cashFlowLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];

// Corresponding data arrays for payments received and sent
$paymentsReceived = [50000, 70000, 65000, 80000, 72000, 90000];
$paymentsSent = [30000, 45000, 40000, 55000, 50000, 60000];

// Pie chart data
$monthlyCashLabels = ['Cash', 'Credit', 'Others'];
$monthlyCashData = [55, 35, 10];


     return view('home', compact('totalOrders', 
       'cashFlowLabels', 
        'paymentsReceived', 
        'paymentsSent', 
        'monthlyCashLabels', 
        'monthlyCashData','totalBookings', 'todayOrders', 'todayBookings' ,'customers' , 'employees' ,'suppliers' , 'Products' ,'Products1'));
    }
}
