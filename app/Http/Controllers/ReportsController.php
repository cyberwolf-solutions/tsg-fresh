<?php

namespace App\Http\Controllers;

use App\Models\checkincheckout;
use App\Models\User;
use App\Models\Booking;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\Purchases;
use Illuminate\Http\Request;
use App\Models\OtherPurchase;

class ReportsController extends Controller
{
    public function user(){
        $title = 'User Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = User::with('roles')->get();


        return view ('reports.Userindex' , compact('title', 'breadcrumbs' , 'data'));
    }

    public function customer(){
        $title = 'Guest Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Customer::all();


        return view ('reports.customerindex' , compact('title', 'breadcrumbs' , 'data'));
    }
    public function employee(){
        $title = 'Employees Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Employee::all();


        return view ('reports.employeeindex' , compact('title', 'breadcrumbs' , 'data'));
    }
    public function supplier(){
        $title = 'Supplier Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Supplier::all();


        return view ('reports.supplierindex' , compact('title', 'breadcrumbs' , 'data'));
    }
    public function purchase(){
        $title = 'Purchase Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Purchases::with(['supplier', 'items.ingredient', 'payments'])->get();
        


        return view ('reports.purchaseindex' , compact('title', 'breadcrumbs' , 'data'));
    }
    public function opurchase(){
        $title = 'Purchase Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = OtherPurchase::with(['supplier', 'items.inventory', 'payments'])->get();
        


        return view ('reports.otherpurchaseindex' , compact('title', 'breadcrumbs' , 'data',));
    }
    // public function purchase(){
    //     $title = 'Purchase Report';
    
    //     $breadcrumbs = [
    //         // ['label' => 'First Level', 'url' => '', 'active' => false],
    //         ['label' => $title, 'url' => '', 'active' => true],
    //     ];
    
    //     $purchases = Purchases::with(['supplier', 'items.ingredient', 'payments'])->get();
    //     $otherPurchases = OtherPurchase::with(['supplier', 'items.inventory', 'payments'])->get();
    
    //     // Merge the two collections
    //     $data = $purchases->merge($otherPurchases);
    
    //     return view('reports.purchaseindex', compact('title', 'breadcrumbs', 'data'));
    // }
    

    
    
    public function product(){
        $title = 'Product Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Product::with('category')->get();


        return view ('reports.productindex' , compact('title', 'breadcrumbs' , 'data'));
    }

    public function reservation(){
        $title = 'Reservation Detail Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = checkincheckout::all();
        return view ('reports.bookingindex' , compact('title', 'breadcrumbs' , 'data'));
    }

    public function booking(){
        $title = 'Booking Detail Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Booking::all();
        return view ('reports.booking1index' , compact('title', 'breadcrumbs' , 'data'));
    }



    public function all(){
        $title = 'Booking Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        
        return view ('reports.rindex' , compact('title', 'breadcrumbs'));
    }

    public function orders(){

        $title = 'Restaurant Orders Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $data = Order::all();


        return view('reports.orderindex' ,compact('title', 'breadcrumbs','data') );



    }

    public function ta(){

        $title = 'Travel agent checkout Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $data = Order::all();


        return view('reports.tacheckout' ,compact('title', 'breadcrumbs','data') );



    }



}
