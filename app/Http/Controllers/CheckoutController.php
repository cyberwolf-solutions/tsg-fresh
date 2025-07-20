<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use App\Models\Room;
use App\Models\Order;
use App\Models\Booking;
use App\Models\checkout;
use App\Models\Customer;
use App\Models\Settings;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use App\Models\RoomFacilities;
use App\Services\EmailService;
use App\Models\checkincheckout;
use App\Models\AdditionalPayment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class CheckoutController extends Controller
{


    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }



    public function index()
    {

        $title = 'Customer Checkout';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];


        $data = checkincheckout::where('status', 'CheckedInANDCheckedOut')
            ->where('type', 'customer')
            ->get();

     return view('pos.bookings.checkout', compact('title', 'breadcrumbs', 'data'));
    }

    public function create()
    {

        $title = 'Customer Checkout';
        $is_edit = true;

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $data = checkincheckout::where('status', 'CheckedIn')
            ->where('type', 'customer')
            ->get();

        $customers = Customer::where('type', 'customer')->get();
        $items = AdditionalPayment::all();

     return view('pos.bookings.addcheckout', compact('title', 'breadcrumbs', 'is_edit', 'data', 'customers', 'items'));
    }
    public function getBookingPaymentDetails($bookingId)
    {
        // Retrieve paid and due amounts for the selected booking
        // $bookingPaymentDetails = CheckinCheckout::where('booking_id', $bookingId)->first();
        $bookingPaymentDetails = CheckinCheckout::with('customer.currency')
            ->where('booking_id', $bookingId)
            ->first();

        $currency = $bookingPaymentDetails?->customer?->currency->name;

        return response()->json([
            'payed' => $bookingPaymentDetails->paid_amount,
            'due' => $bookingPaymentDetails->due_amount,
            'total_amount' => $bookingPaymentDetails->total_amount,
            'currencytype' => $currency
        ]);
    }

    public function getCustomerOrders($customerId)
    {
        // Fetch orders for the specified customer ID where type = RoomDelivery
        $orders = Order::where('customer_id', $customerId)
            ->where('type', 'RoomDelivery')
            ->get();


        $orderIds = $orders->pluck('id');

        $unpaidOrders = OrderPayment::whereIn('order_id', $orderIds)
            ->where('payment_status', 'Unpaid')
            ->get();

        return response()->json([
            'orders' => $orders,
            'orderIds' => $orderIds,
            'unpaidOrders' => $unpaidOrders,
        ]);
    }
    public function getBookingRooms(Request $request)
    {
        $id = $request['id'];
        $booking = Booking::find($id);

        $settings = Settings::latest()->first();

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<th>Room Name</th>';
        $html .= '<th>Room No</th>';
        $html .= '<th>Room Type</th>';
        $html .= '<th>Room Capacity</th>';
        $html .= '<th>Room Price</th>';
        $html .= '</tr>';

        foreach ($booking->rooms as $room) {
            $html .= '<tr>';
            $html .= '<td>' . $room->name . '</td>';
            $html .= '<td>' . $room->room_no . '</td>';
            $html .= '<td>' . $room->types->name . '</td>';
            $html .= '<td>' . $room->capacity . '</td>';
            $html .= '<td>' . $settings->currency . ' ' . number_format($room->price, 2) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';

        return response()->json([$html]);
    }

    // public function getcheckoutRooms(Request $request)
    // {
    //     $id = $request['id'];
    //     $booking = Booking::find($id);

    //     $settings = Settings::latest()->first();

    //     $html = '<table class="table" cellspacing="0" cellpadding="0">';
    //     $html .= '<tr>';
    //     $html .= '<th>Room Name</th>';
    //     $html .= '<th>Room No</th>';
    //     $html .= '<th>Room Type</th>';
    //     $html .= '<th>Room Capacity</th>';
    //     $html .= '<th>Room Price</th>';
    //     $html .= '</tr>';

    //     foreach ($booking->rooms as $room) {
    //         $html .= '<tr>';
    //         $html .= '<td>' . $room->name . '</td>';
    //         $html .= '<td>' . $room->room_no . '</td>';
    //         $html .= '<td>' . $room->types->name . '</td>';
    //         $html .= '<td>' . $room->capacity . '</td>';
    //         $html .= '<td>' . $settings->currency . ' ' . number_format($room->price, 2) . '</td>';
    //         $html .= '</tr>';
    //     }

    //     $html .= '</table>';

    //     return response()->json([$html]);
    // }

    // public function getcheckoutRooms($customerId)
    // {
    //     // $customer = Customer::with('bookings.rooms')->findOrFail($customerId);

    //     // return response()->json($customer->bookings);
    //     $customer = Customer::with(['checkinCheckouts' => function($query) {
    //         $query->where('status', 'checked in');
    //     }])->findOrFail($customerId);

    //     // Get only the checkin-checkout records with status 'checked in'
    //     $checkinCheckouts = $customer->checkinCheckouts->where('status', 'checked in');

    //     // Return the data as a JSON response
    //     return response()->json($checkinCheckouts);
    // }

    public function getCheckinCheckoutId(Request $request)
    {

        $customerId = $request->input('customer_id');
        $bookingId = $request->input('booking_id');
        $roomNo = $request->input('roomno');


        // $checkinCheckoutId = CheckinCheckout::where('customer_id', $customerId)
        //     ->where('booking_id', $bookingId)
        //     ->value('id');
        $checkinCheckoutId = CheckinCheckout::where('customer_id', $customerId)
            ->where('booking_id', $bookingId)
            ->where('room_no', $roomNo)
            ->value('id');


        return response()->json(['checkincheckout_id' => $checkinCheckoutId]);
    }

    public function store(Request $request)
    {
        $tableData = json_decode($request->input('table_data'), true);

        $validator = Validator::make($request->all(), [
            'additional' => 'required',
            'tot' => 'required',
            'booking_id' => 'required',
            'ftot' => 'required',
            'room_no' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all()
            ]);
        }

        $rid = $request->booking_room_id;
        $id = $request->checkincheckout_id;
        $room_no = $request->room_no;

        $checkout = checkincheckout::where('id', $id)->where('room_no', $room_no)->first();
        $room = Room::find($rid);
        $full_payed_amount = $request->payed + $request->fd;

        try {
            if ($checkout && $room) {
                $checkout->update([
                    'additional_payment' => $request->input('additional'),
                    'note' => $request->input('note'),
                    'full_payment' => $request->input('tot'),
                    'status' => 'CheckedInANDCheckedOut',
                    'full_payed_amount' => $full_payed_amount,
                    'final_full_total' => $request->input('ftot'),
                    'additional_services' => json_encode($tableData)
                ]);

                $room->update([
                    'status' => 'Cleaning'
                ]);

                // Update unpaid orders to paid
                $customerId = $checkout->customer_id;
                $orders = Order::where('customer_id', $customerId)
                    ->where('type', 'RoomDelivery')
                    ->get();

                $orderIds = $orders->pluck('id');

                OrderPayment::whereIn('order_id', $orderIds)
                    ->where('payment_status', 'Unpaid')
                    ->update(['payment_status' => 'Paid']);

                $booking = Booking::findOrFail($request->booking_id);
                $booking->status = 'Complete';
                $booking->save();

                // Prepare invoice view data
                $viewData = [
                    'data' => $checkout,
                ];

                $body = view('bookings.invoice', $viewData)->render();

                // Send email
                $to = $request->input('email');
                $subject = "Invoice";
                $result = $this->emailService->sendEmail($to, $subject, $body);

                if ($result) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Checkout data has been saved successfully.',
                        'redirect' => route('checkout.invoice', [$request->checkincheckout_id])
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to send E-bill'
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout or Room not found.'
                ]);
            }
        } catch (\Throwable $th) {
            // Log detailed error
            Log::error('Checkout Error', [
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return detailed error in response (dev only)
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
                'line' => $th->getLine(),
                'file' => $th->getFile()
            ]);
        }
    }



    public function invoice(string $checkincheckout_id)
    {

        $data = checkincheckout::find($checkincheckout_id);

        $additionalPayments = json_decode($data->additional_services, true);

        // $totalAdditionalPayment = 0;

        // // Sum up the prices of additional services
        // foreach ($additionalPayments as $payment) {
        //     $totalAdditionalPayment += (float) $payment['price'];
        // }



        $totalAdditionalPayment = 0;


        if (is_array($additionalPayments)) {

            foreach ($additionalPayments as $payment) {
                $totalAdditionalPayment += (float) $payment['price'];
            }
        }


     return view('pos.bookings.invoice', compact('data', 'totalAdditionalPayment'));
    }


    public function additionalInvoice($customerId, $checkoutDate)
    {

        $cid = $customerId;

        $checkinCheckout = CheckinCheckout::where('customer_id', $customerId)
            ->whereDate('checkout', $checkoutDate)
            ->first();

        $updatedAt = $checkinCheckout ? $checkinCheckout->updated_at->format('Y-m-d') : null;

        if ($checkinCheckout) {

            $updatedAt = $checkinCheckout->updated_at->format('Y-m-d');

            $customerId = $checkinCheckout->customer_id;


            $orders = Order::where('customer_id', $customerId)
                ->where('type', 'RoomDelivery')
                ->get();

            $orderIds = $orders->pluck('id');

            $orderItems = OrderItem::whereIn('order_id', $orderIds)->get();


            $data = OrderPayment::whereDate('updated_at', $updatedAt)->get();
        }







     return view('pos.bookings.additional', compact('data', 'checkinCheckout', 'orders', 'orderItems', 'cid'));
    }

    public function additionalServiceInvoice($customerId, $checkoutDate)
    {

        $cid = $customerId;

        $checkinCheckout = CheckinCheckout::where('customer_id', $customerId)
            ->whereDate('checkout', $checkoutDate)
            ->first();

        $updatedAt = $checkinCheckout ? $checkinCheckout->updated_at->format('Y-m-d') : null;

        $additionalServices = $checkinCheckout ? json_decode($checkinCheckout->additional_services, true) : [];






     return view('pos.bookings.additionalservice', compact('checkinCheckout', 'additionalServices'));
    }
}
