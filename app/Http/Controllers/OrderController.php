<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Settings;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'POS Orders';
        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $status = $request->status;

        // Fetch only POS orders
        $query = Order::where('source', 'POS');

        // Apply status filter if provided
        if ($status) {
            $query->where('status', $status);
        }

        // Eager load related customer and order items
        $data = $query->with(['customer', 'items.product', 'items.variant'])->get();

        return view('pos.order.index', compact('title', 'breadcrumbs', 'data', 'status'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function web(Request $request)
    {

        $title = 'WEB Orders';
        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $status = $request->status;

        // Fetch orders created from web
        $data = Order::where('source', 'WEB')
            ->where('delivery_method', '!=', 'Pickup') // exclude pickup orders
            ->with(['items.product', 'items.variant'])
            ->orderBy('order_date', 'desc')
            ->get();

        return view('pos.order.webindex', compact('title', 'breadcrumbs', 'data', 'status'));
    }

    // Show all in-store pickup orders from web
    public function instore(Request $request)
    {
        $title = 'Instore Pickup Orders';
        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $status = $request->status;

        // Fetch web orders that have delivery_method as Pickup
        $data = Order::where('source', 'WEB')
            ->where('delivery_method', 'Pickup')
            ->with(['items.product', 'items.variant'])
            ->orderBy('order_date', 'desc')
            ->get();


        return view('pos.order.instore', compact('title', 'breadcrumbs', 'data', 'status'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Try to find the order with items and related customer
            $data = Order::with(['items.product', 'items.variant', 'webCustomer', 'customer'])
                ->find($id);

            if (!$data) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            return view('pos.order.show', compact('data'));
        } catch (\Throwable $e) {
            // Catch any error and dump it
            dd([
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
    // public function updateStatus(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|exists:orders,id',
    //         'status' => 'required|string'
    //     ]);

    //     $order = Order::findOrFail($request->id);

    //     // Validate allowed statuses based on source
    //     if (!in_array($request->status, $order->nextStatuses())) {
    //         return response()->json(['success' => false, 'message' => 'Invalid status for this order.']);
    //     }

    //     $order->status = $request->status;
    //     $order->save();

    //     return response()->json(['success' => true, 'status' => $order->status]);
    // }

    public function updateStatus(Request $request)
    {
        //  dd($request->all());

        try {

            $request->validate([
                'id' => 'required',
                'status' => 'required|string'
            ]);
            $order = Order::findOrFail($request->id);
            $order->status = $request->status;
            $order->save();

            // return response()->json(['success' => true, 'status' => $order->status]);
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!',
                'status'  => $order->status,
            ]);
        } catch (\Exception $e) {
            Log::error('Status update failed:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function payment(Request $request)
    {
        $request->validate([
            'order_id'      => 'required|integer',
            'date'          => 'required|date',
            'sub_total'     => 'required|numeric',
            'vat'           => 'nullable|numeric',
            'discount'      => 'nullable|numeric',
            'total'         => 'required|numeric',
            'payment_type'  => 'required|in:Cash,Card',
            'payment_status' => 'required|in:Unpaid,Partially Paid,Paid',
        ]);

        $payment = OrderPayment::create([
            'order_id'      => $request->order_id,
            'date'          => $request->date,
            'sub_total'     => $request->sub_total,
            'vat'           => $request->vat,
            'discount'      => $request->discount,
            'total'         => $request->total,
            'payment_type'  => $request->payment_type,
            'description'   => $request->description,
            'payment_status' => $request->payment_status,
            'created_by'    => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment saved successfully',
            'data'    => $payment
        ]);
    }
    public function print(string $id)
    {
        $data = Order::find($id);
        return view('pos.order.print', compact('data'));
    }

    public function printtax(string $id)
    {
        $data = Order::find($id);
        return view('pos.order.printtax', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}

    public function invoice(Request $request)
    {
        $orderId = $request->id;

        $order = Order::with(['items.product', 'items.variant', 'customer'])->findOrFail($orderId);

        $settings = Settings::latest()->first();
        $data = $order;

        return view('pos.order.print', compact('data', 'settings'));
    }


    // Example helper inside controller
    // protected function getBankDetails()
    // {
    //     return BankDetail::first(); // adapt as per your structure
    // }

    public function view(string $id)
    {
        $order = Order::findOrFail($id);
        $webCustomer = Auth::guard('customer')->user();

        $customer = Auth::guard('customer')->user();
        $billingAddress = $customer->billingAddress;

        return view('customer.orderDetails', compact('order', 'webCustomer', 'billingAddress'));
    }
}
