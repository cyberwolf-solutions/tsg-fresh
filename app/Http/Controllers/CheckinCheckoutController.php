<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\RoomFacilities;
use App\Models\checkincheckout;
use App\Models\RoomPricing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CheckinCheckoutController extends Controller
{
    public function index(Request $request)
    {


        // dump and die — check what data you're receiving

        $title = 'Checkin';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = CheckinCheckout::with('customer', 'roomType')->get();
     return view('pos.bookings.checkin', compact('title', 'breadcrumbs', 'data'));
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $title = 'Checkin';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];


        $customers = Customer::whereHas('bookings', function ($query) {
            $query->where('status', 'Pending');
        })->with('bookings.rooms')->get();

        $is_edit = false;
        $data = Booking::where('status', 'OnGoing')->get();
        $data1 = Room::all();
        $data2 = RoomPricing::all();

     return view('pos.bookings.addcheckin', compact('title', 'breadcrumbs', 'data', 'is_edit', 'data1', 'customers', 'data2'));
    }

    public function getBookingRooms($customerId)
    {
        // Fetch the customer with their bookings (including rooms) and currency information.
        $customer = Customer::with([
            'bookings' => function ($query) {
                $query->where('status', '!=', 'Complete');
            },
            'bookings.rooms', // nested relationship still works
            'currency'
        ])->findOrFail($customerId);
        
        // Assume that the customer's currency model has a 'name' property like "LKR", "USD", or "EUR".
        $currencyCode = strtoupper($customer->currency->name);

        // Map through each booking to include the relevant price based on the customer's currency.
        $bookings = $customer->bookings->map(function ($booking) use ($currencyCode) {
            // Determine the relevant price from the booking data.
            switch ($currencyCode) {
                case 'LKR':
                    $booking->relevant_price = $booking->total_lkr;
                    break;
                case 'USD':
                    $booking->relevant_price = $booking->total_usd;
                    break;
                case 'EUR':
                    $booking->relevant_price = $booking->total_eur;
                    break;
                default:
                    // If the currency does not match one of the above, you can set a default or fallback price.
                    $booking->relevant_price = 0;
                    break;
            }
            // The booking already has its related rooms loaded (via the 'rooms' relationship).
            return $booking;
        });
        Log::info('bookings okokok', ['bookings' => $bookings->toArray()]); // 

        // Return a JSON response with the customer's currency code, bookings, and the rooms for each booking.
        return response()->json([
            'currency' => $currencyCode,
            'bookings' => $bookings,
        ]);
    }
    

    public function getRoomFacility($facilityId)
    {

        $facility = RoomFacilities::find($facilityId);


        if ($facility) {

            return response()->json(['name' => $facility->name]);
        } else {

            return response()->json(['error' => 'Facility not found'], 404);
        }
    }

    public function store(Request $request)
    {
        // Decode the table data from the form input
        $tableData = json_decode($request->input('table_data'), true);

        // Log the full request input for debugging purposes
        Log::info('Full request input:', $request->all());

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'booking_room_id' => 'required',
            'booking_id' => 'required',
            'room_facility' => 'required',
            'room_no' => 'required',
            'checkin' => 'required',
            'checkout' => 'required',
            'total' => 'required',
            'payed' => 'required',
            'due' => 'required',
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Retrieve the booking and customer
            $booking = Booking::findOrFail($request->booking_id);
            $customer = Customer::findOrFail($request->customer_id);
            $customerType = 'customer'; // Default type is customer

            // Check the booking's 'ta' field to decide the customer type
            if ($booking->ta !== "null") {
                $customerType = 'travel agent'; // Set type to travel agent if 'ta' is not null
                $tais = $request->customer_id;
            } else {
                $tais = "null";
            }

            // Log the received table data for debugging
            Log::info('TableData received:', ['data' => $tableData]);

            // Loop through the table data and insert into the database
            foreach ($tableData['data'] as $roomData) {
                $room = Room::where('room_no', $roomData['roomNo'])->first();
                $checkinCheckout = new CheckInCheckout();
                $checkinCheckout->booking_id = $request->input('booking_id');
                $checkinCheckout->customer_id = $request->input('customer_id');
                $checkinCheckout->room_type = $room?->name;
                $checkinCheckout->room_facility_type = $roomData['facility'];
                $checkinCheckout->room_no = $roomData['roomNo'];
                $checkinCheckout->checkin = $request->input('checkin');
                $checkinCheckout->checkout = $request->input('checkout');
                $checkinCheckout->total_amount = $roomData['totalAmount'] ?? 0;  // Default to 0 if null
                $checkinCheckout->paid_amount = $roomData['payingAmount'] ?? 0;  // Default to 0 if null
                $checkinCheckout->due_amount = $roomData['dueAmount'] ?? 0;  // Default to 0 if null
                $checkinCheckout->status = 'CheckedIn';
                $checkinCheckout->ta = $tais;
                $checkinCheckout->type = $customerType;
                // $checkinCheckout->created_by = Auth::user()->id;

                // Save the checkinCheckout record
                $checkinCheckout->save();

                $room->update([
                    'status' => 'Reserved'
                ]);
                // Log the checkinCheckout record creation
                Log::info('CheckinCheckout record created:', ['checkinCheckout' => $checkinCheckout]);
            }

            // After processing all rooms, update the booking status to 'OnGoing'
            // $booking->status = 'OnGoing';
            // $booking->save();

            $booking->update([
                'status' => 'OnGoing'
            ]);

            // Return a success response with a redirect URL
            return response()->json([
                'success' => true,
                'message' => 'Customer Checked In',
                'url' => route('checkin.index')
            ]);
        } catch (\Throwable $th) {
            // Log the error if something goes wrong
            Log::error("Error during check-in process: " . $th->getMessage());

            // Return an error response with the exception message
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $th->getMessage()
            ]);
        }
    }
    public function destroy($id)
    {
        try {
            $checkin = CheckinCheckout::findOrFail($id);


            $checkin->delete();


            return redirect()->route('checkin.index')->with('success', 'Checkin deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}
