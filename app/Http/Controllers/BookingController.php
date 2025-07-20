<?php

namespace App\Http\Controllers;

use DateTime;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\RoomType;
use App\Models\Settings;
use App\Models\BordingType;
use App\Models\RoomPricing;
use Illuminate\Http\Request;
use App\Models\BookingsRooms;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Bookings';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        // Retrieve all bookings, including soft deleted records
        $data = Booking::withTrashed()->get();

     return view('pos.bookings.index', compact('title', 'breadcrumbs', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Validate new guest input
        $validator = Validator::make($request->all(), [
            'checkin' => 'required',
            'checkout' => 'required',
            'no_of_adults' => 'required',
            'room' => 'required',
            // 'name' => 'required',
            // 'type' => 'required',
            // 'currency' => 'required',
        ]);

        if ($validator->fails()) {
            $all_errors = null;
            foreach ($validator->errors()->messages() as $errors) {
                foreach ($errors as $error) {
                    $all_errors .= $error . "<br>";
                }
            }

            return response()->json(['success' => false, 'message' => $all_errors]);
        }

        $image_url = null;
        if ($request->file('image') != null) {
            $preferred_name = trim($request->name);
            $image_url = $preferred_name . '.' . $request['image']->extension();
            $request['image']->move(public_path('uploads/guests'), $image_url);
        }

        // Use existing guest if selected
        $existingGuestId = $request->existing_customer_id;
        $existingTA =  $request->existing_ta_id;
        $Customer = null;

        if (!$existingTA) {
            $existingTA = "null";
        }
        if ($existingGuestId) {
            // Use the selected customer or travel agent
            $Customer = Customer::find($existingGuestId);

            if (!$Customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected customer or travel agent not found.'
                ]);
            }
        } else {


            // Create new customer
            $cust_data = [
                'name' => $request->name,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'type' => $request->type,
                'currency_id' => $request->currency,
                'created_by' => Auth::user()->id,
            ];

            $Customer = Customer::create($cust_data);
        }

        // Proceed with booking
        try {
            // $status = (($request->checkin > date("Y-m-d")) ? 'Pending' : 'OnGoing');
            $status =  'Pending';
            $total_lkr = 0;
            $total_usd = 0;
            $total_eur = 0;

            foreach ($request->room as $roomId) {
                $pricing = RoomPricing::where('room_id', $roomId)
                    ->where('boarding_type_id', $request->bording)
                    ->where('room_type_id', $request->roomtype)
                    ->first();

                if ($pricing) {
                    $total_lkr += $pricing->price_lkr;
                    $total_usd += $pricing->price_usd;
                    $total_eur += $pricing->price_eu;
                }
            }

            $booking_data = [
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'no_of_adults' => $request->no_of_adults,
                'no_of_children' => $request->no_of_children,
                'customer_id' => $Customer->id,
                'ta' => $existingTA,
                'status' => $status,
                'created_by' => Auth::user()->id,
                'total_lkr' => $total_lkr,
                'total_usd' => $total_usd,
                'total_eur' => $total_eur,
            ];

            $Booking = Booking::create($booking_data);

            if ($Booking != null) {
                foreach ($request->room as $roomId) {
                    $broom_data = [
                        'booking_id' => $Booking->id,
                        'room_id' => $roomId,
                        'created_by' => Auth::user()->id,
                        'bording_id' => $request->bording,
                        'roomtype_id' => $request->roomtype,
                    ];

                    BookingsRooms::create($broom_data);

                    if ($status == 'OnGoing') {
                        Room::where('id', $roomId)->update([
                            'status' => 'Reserved',
                            'updated_by' => Auth::user()->id,
                        ]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully.',
                'url' => route('bookings.index')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! ' . $th->getMessage()
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $data = Booking::find($id);

        $data = Booking::withTrashed()->find($id);

        $settings = Settings::latest()->first();
        $noOfDays = (Carbon::parse($data->checkin))->diffInDays(Carbon::parse($data->checkout));
        $total = 0;
        foreach ($data->rooms as $room) {
            $total += $noOfDays * ($room->price);
        }

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<td>Guest :</td>';
        $html .= '<td><a href="javascript:void(0)" data-url="' . route('get-booking-customers') . '"
                    data-id="' . $data->customers->id . '" class="show-modal">' . $data->customers->name . '</a></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Check In :</td>';
        $html .= '<td>' . date_format(new DateTime('@' . strtotime($data->checkin)), $settings->date_format) . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Check Out :</td>';
        $html .= '<td>' . date_format(new DateTime('@' . strtotime($data->checkout)), $settings->date_format) . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>No of Adults/Children :</td>';
        $html .= '<td>' . $data->no_of_adults . '/' . $data->no_of_children . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Status :</td>';
        $html .= '<td>' . $data->status . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Rooms :</td>';
        $html .= '<td><a href="javascript:void();" data-url="' . route('get-booking-rooms') . '"
                    data-id="' . $data->id . '" class="show-modal">View Rooms</a></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Cancellation Reason :</td>';
        $html .= '<td>';
        if ($data->cancel_reason) {
            $html .= $data->cancel_reason;
        } else {
            $html .= 'Booking Ongoing';
        }
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '<td>Total(Room Charges Only) :</td>';
        $html .= '<td>' . $settings->currency . ' ' . number_format($total, 2) . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created By :</td>';
        $html .= '<td>' . $data->createdBy->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Created Date :</td>';
        $html .= '<td>' . date_format(new DateTime('@' . strtotime($data->created_at)), $settings->date_format) . '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return response()->json([$html]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = 'Bookings';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        $data = Booking::find($id);

        //Get Available Rooms
        $selectedRooms = null;

        $settings = Settings::latest()->first();
        $selectedArray = [];
        $selectedR = $data['rooms']->chunk(3);
        foreach ($selectedR as $row) {
            $selectedRooms = '<div class="row">';
            foreach ($row as $item) {
                array_push($selectedArray, $item['id']);
                if ($item->image_url != null) {
                    $image = 'uploads/rooms/' . $item->image_url;
                } else {
                    $image = 'https://placehold.co/50';
                }

                $selectedRooms .= '<div class="col-md-4">';
                $selectedRooms .= '<div class="form-check form-check-inline">';
                $selectedRooms .= '<input class="form-check-input form-control" type="checkbox" name="room[]" id=""
                                                value="' . $item['id'] . '" checked>';
                $selectedRooms .= '<div class="card border">';
                $selectedRooms .= '<img src=" ' . $image . ' " alt="" class="card-img-top">';
                $selectedRooms .= '<div class="card-body text-center">';
                $selectedRooms .= '<p class="card-text small"> Name: ' . $item['name'] . ' </p>';
                $selectedRooms .= '<p class="card-text small"> Room No: ' . $item['room_no'] . ' </p>';
                $selectedRooms .= '<p class="card-text small"> Capacity: ' . $item['capacity'] . ' </p>';
                $selectedRooms .= '<p class="card-text small"> Room Type: ' . $item['types']['name'] . ' </p>';
                $selectedRooms .= '<p class="card-text small"> Price: ' . $settings->currency . ' ' . number_format($item['price'], 2) . ' </p>';
                $selectedRooms .= '</div>';
                $selectedRooms .= '</div>';
                $selectedRooms .= '</div>';
                $selectedRooms .= '</div>';
            }
            $selectedRooms .= '</div>';
        }

        $selected = implode(', ', $selectedArray);

     return view('pos.bookings.edit', compact('title', 'breadcrumbs', 'data', 'selectedRooms', 'selected'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'checkin' => 'required',
            'checkout' => 'required',
            'no_of_adults' => 'required',
            'room' => 'required',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            $all_errors = null;

            foreach ($validator->errors()->messages() as $errors) {
                foreach ($errors as $error) {
                    $all_errors .= $error . "<br>";
                }
            }

            return response()->json(['success' => false, 'message' => $all_errors]);
        }

        try {
            $booking_data = [
                'checkin' => $request->checkin,
                'checkout' => $request->checkout,
                'no_of_adults' => $request->no_of_adults,
                'no_of_children' => $request->no_of_children,
                'updated_by' => Auth::user()->id,
            ];

            $booking = Booking::find($id)->update($booking_data);
            $Booking = Booking::find($id);

            $cust_data = [
                'name' => $request->name,
                'contact' => $request->contact,
                'email' => $request->email,
                'address' => $request->address,
                'updated_by' => Auth::user()->id,
            ];

            $customer = Customer::find($Booking->customers->id)->update($cust_data);

            $selected = explode(',', $request->selected);

            foreach ($selected as $sel) {
                $room_data = [
                    'status' => 'Available',
                    'updated_by' => Auth::user()->id,
                ];

                $room = Room::find($sel)->update($room_data);
            }

            foreach ($request->room as $room) {
                $deleted = BookingsRooms::where('booking_id', $id)->get();
                $deleted->each->delete();
                $broom_data = [
                    'booking_id' => $Booking->id,
                    'room_id' => $room,
                    'created_by' => Auth::user()->id,
                ];

                $BookingRoom = BookingsRooms::create($broom_data);

                if ($Booking->status == 'OnGoing') {
                    $room_data = [
                        'status' => 'Reserved',
                        'updated_by' => Auth::user()->id,
                    ];

                    $room = Room::find($room)->update($room_data);
                }
            }

            return json_encode(['success' => true, 'message' => 'Booking updated', 'url' => route('bookings.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     try {
    //         $Booking = Booking::find($id);
    //         $Booking->update(['status' => 'Cancelled']);
    //         $Booking->update(['deleted_by' => Auth::user()->id]);
    //         $Booking->delete();
    //         $BookingRooms = BookingsRooms::where('booking_id', $id)->get();
    //         $BookingRooms->each->delete();

    //         foreach ($BookingRooms as $bookingRoom) {
    //             $room = Room::find($bookingRoom->room_id);


    //             $room->update(['status' => 'Available']);
    //         }



    //         return json_encode(['success' => true, 'message' => 'Booking deleted', 'url' => route('bookings.index')]);
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return json_encode(['success' => false, 'message' => 'Something went wrong!']);
    //     }
    // }

    public function destroy(string $id)
    {
        try {
            $Booking = Booking::find($id);

            // Update the booking status to 'Cancelled' and mark who deleted it
            $Booking->update(['status' => 'Cancelled', 'deleted_by' => Auth::user()->id]);

            // Soft delete the booking
            $Booking->delete();

            // Get associated booking rooms
            $BookingRooms = BookingsRooms::where('booking_id', $id)->get();

            // Update the status of each room to 'Available'
            foreach ($BookingRooms as $bookingRoom) {
                $room = Room::find($bookingRoom->room_id);
                if ($room) {
                    $room->update(['status' => 'Available']);
                }
            }

            return json_encode(['success' => true, 'message' => 'Booking cancelled', 'url' => route('bookings.index')]);
        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => 'Something went wrong!']);
        }
    }





    /**
     * Check Availability View.
     */
    public function checkAvailability()
    {
        $title = 'Check Availability';
        $cus = RoomType::all();
        $currencies = Currency::all();
        $guests = Customer::all();
        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = BordingType::all();
     return view('pos.bookings.check-availability', compact('title', 'cus', 'data', 'breadcrumbs', 'currencies', 'guests'));
    }


    /**
     * Get Available Rooms for Specific Booking
     */
    // public function getAvailableRooms(Request $request)
    // {


    //     // dd($request->all());

    //     $formData = $request->formData;
    //     $count = $formData['no_of_adults'] + $formData['no_of_children'];

    //     try {

    //         // $availability = Booking::where('checkin', '>=', $formData['checkin'])
    //         //     ->orWhere('checkout', '<=', $formData['checkout'])->get();
    //         $checkin = $formData['checkin'];
    //         $checkout = $formData['checkout'];

    //         $availability = Booking::where(function ($query) use ($checkin, $checkout) {
    //             $query->where('checkin', '>=', $checkin)
    //                 ->where('checkin', '<', $checkout);
    //         })->orWhere(function ($query) use ($checkin, $checkout) {
    //             $query->where('checkout', '>', $checkin)
    //                 ->where('checkout', '<=', $checkout);
    //         })->orWhere(function ($query) use ($checkin, $checkout) {
    //             $query->where('checkin', '<', $checkin)
    //                 ->where('checkout', '>', $checkout);
    //         })->get();

    //         $roomTypeCount = null;

    //         $bookedRooms = [];
    //         foreach ($availability as $aval) {
    //             foreach ($aval->rooms as $room) {
    //                 array_push($bookedRooms, $room->id);
    //             }
    //         }

    //         $availabilityIds = $availability->pluck('id')->toArray();

    //         if (count($availability) != 0) {
    //             $availableRooms = Room::where('capacity', '>=', $count)->where('status', 'Available')->whereNotIn('id', $availabilityIds)->get();
    //         } else {
    //             $availableRooms = Room::where('capacity', '>=', $count)->where('status', 'Available')->get();
    //         }

    //         foreach ($availableRooms as $rooms) {
    //             $roomTypeCount[$rooms['types']['name']] = (isset($roomTypeCount[$rooms['types']['name']]) ? $roomTypeCount[$rooms['types']['name']] + 1 : 1);
    //         }

    //         $roomTypeArr = [];
    //         $roomTypeDetails = $availableRoomDetails = null;

    //         //Get Available Room Types - Single, Double
    //         if ($roomTypeCount != null) {
    //             $roomTypeArr = array_chunk($roomTypeCount, 3, true);
    //             foreach ($roomTypeArr as $row) {
    //                 $roomTypeDetails = '<div class="row">';
    //                 foreach ($row as $k => $item) {
    //                     $roomTypeDetails .= '<div class="col-md-4">';
    //                     $roomTypeDetails .= '<h4><strong> ' . $k . ' </strong> : ' . $item . ' </h4>';
    //                     $roomTypeDetails .= '</div>';
    //                 }
    //                 $roomTypeDetails .= '</div>';
    //             }
    //         }

    //         $settings = Settings::latest()->first();
    //         if ($availableRooms != null) {
    //             $availableRooms = $availableRooms->chunk(3);
    //             foreach ($availableRooms as $row) {
    //                 $availableRoomDetails = '<div class="row">';
    //                 foreach ($row as $item) {
    //                     if ($item->image_url != null) {
    //                         $image = 'uploads/rooms/' . $item->image_url;
    //                     } else {
    //                         $image = 'https://placehold.co/50';
    //                     }

    //                     $availableRoomDetails .= '<div class="col-md-4">';
    //                     $availableRoomDetails .= '<div class="form-check form-check-inline">';
    //                     $availableRoomDetails .= '<input class="form-check-input form-control" type="checkbox" name="room[]" id=""
    //                                                 value="' . $item['id'] . '">';
    //                     $availableRoomDetails .= '<div class="card border">';
    //                     $availableRoomDetails .= '<img src=" ' . $image . ' " alt="" class="card-img-top">';
    //                     $availableRoomDetails .= '<div class="card-body text-center">';
    //                     $availableRoomDetails .= '<p class="card-text small"> Name: ' . $item['name'] . ' </p>';
    //                     $availableRoomDetails .= '<p class="card-text small"> Room Facility: ' . $item->roomFacility->name . ' </p>';
    //                     $availableRoomDetails .= '<p class="card-text small"> Room No: ' . $item['room_no'] . ' </p>';
    //                     $availableRoomDetails .= '<p class="card-text small"> Capacity: ' . $item['capacity'] . ' </p>';
    //                     $availableRoomDetails .= '<p class="card-text small"> Room Type: ' . $item['types']['name'] . ' </p>';
    //                     $availableRoomDetails .= '<p class="card-text small"> Price(Per Night): ' . $settings->currency . ' ' . number_format($item['price'], 2) . ' </p>';
    //                     $availableRoomDetails .= '</div>';
    //                     $availableRoomDetails .= '</div>';
    //                     $availableRoomDetails .= '</div>';
    //                     $availableRoomDetails .= '</div>';
    //                 }
    //                 $availableRoomDetails .= '</div>';
    //             }
    //         }

    //         return response()->json(['roomTypeDetails' => $roomTypeDetails, 'availableRoomDetails' => $availableRoomDetails]);
    //     } catch (\Throwable $th) {
    //         return response()->json(['success' => false, 'message' => $th->getMessage()]);
    //     }
    // }


    public function getAvailableRooms(Request $request)
    {
        $formData = $request->formData;
        $count = $formData['no_of_adults'] + $formData['no_of_children'];
        $boardingTypeId = $formData['bording']; // Selected boarding type
        $roomTypeId = $formData['roomtype'];    // Selected room type

        try {
            $checkin = $formData['checkin'];
            $checkout = $formData['checkout'];

            // Get overlapping bookings
            $availability = Booking::where(function ($query) use ($checkin, $checkout) {
                $query->where('checkin', '>=', $checkin)
                    ->where('checkin', '<', $checkout);
            })->orWhere(function ($query) use ($checkin, $checkout) {
                $query->where('checkout', '>', $checkin)
                    ->where('checkout', '<=', $checkout);
            })->orWhere(function ($query) use ($checkin, $checkout) {
                $query->where('checkin', '<', $checkin)
                    ->where('checkout', '>', $checkout);
            })->get();

            // Collect booked room IDs
            $bookedRoomIds = [];
            foreach ($availability as $booking) {
                foreach ($booking->rooms as $room) {
                    $bookedRoomIds[] = $room->id;
                }
            }

            // Base room query
            $availableRoomsQuery = Room::where('capacity', '>=', $count)
                ->where('status', 'Available')
                ->whereNotIn('id', $bookedRoomIds);

            // Filter by RoomPricing (boarding + room type)
            if ($boardingTypeId || $roomTypeId) {
                $availableRoomsQuery = $availableRoomsQuery->whereHas('pricings', function ($query) use ($boardingTypeId, $roomTypeId) {
                    if ($boardingTypeId) {
                        $query->where('boarding_type_id', $boardingTypeId);
                    }
                    if ($roomTypeId) {
                        $query->where('room_type_id', $roomTypeId);
                    }
                });
            }

            $availableRooms = $availableRoomsQuery->get();

            // Group by room types
            $roomTypeCount = [];
            foreach ($availableRooms as $room) {
                $roomTypeName = optional($room->types)->name ?? 'N/A';
                $roomTypeCount[$roomTypeName] = isset($roomTypeCount[$roomTypeName]) ? $roomTypeCount[$roomTypeName] + 1 : 1;
            }

            // Render room type summary
            $roomTypeDetails = '';
            if ($roomTypeCount) {
                $roomTypeChunks = array_chunk($roomTypeCount, 3, true);
                foreach ($roomTypeChunks as $row) {
                    $roomTypeDetails .= '<div class="row">';
                    foreach ($row as $type => $count) {
                        $roomTypeDetails .= '<div class="col-md-4">';
                        $roomTypeDetails .= '<h4><strong>' . $type . ' </strong>: ' . $count . ' </h4>';
                        $roomTypeDetails .= '</div>';
                    }
                    $roomTypeDetails .= '</div>';
                }
            }

            // Room detail cards
            $settings = Settings::latest()->first();
            $availableRoomDetails = '';

            if ($availableRooms->isNotEmpty()) {
                $availableRoomsChunks = $availableRooms->chunk(3);
                foreach ($availableRoomsChunks as $row) {
                    $availableRoomDetails .= '<div class="row">';
                    foreach ($row as $room) {
                        $pricing = $room->pricings()
                            ->where('boarding_type_id', $boardingTypeId)
                            ->where('room_type_id', $roomTypeId)
                            ->first();

                        $priceLKR = $pricing->price_lkr;
                        $priceUSD = $pricing->price_usd;
                        $priceEU = $pricing->price_eu;


                        $image = $room->image_url ? asset('uploads/rooms/' . $room->image_url) : 'https://placehold.co/50';
                        $availableRoomDetails .= '<div class="col-md-4">';
                        $availableRoomDetails .= '<div class="form-check form-check-inline">';
                        $availableRoomDetails .= '<input class="form-check-input form-control" type="checkbox" name="room[]" value="' . $room->id . '">';
                        $availableRoomDetails .= '<div class="card border">';
                        $availableRoomDetails .= '<img src="' . $image . '" alt="" class="card-img-top">';
                        $availableRoomDetails .= '<div class="card-body text-center">';
                        $availableRoomDetails .= '<p class="card-text small"> Name: ' . $room->name . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Room Facility: ' . optional($room->RoomFacility)->name . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Room No: ' . $room->room_no . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Capacity: ' . $room->capacity . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Room Type: ' . optional($room->types)->name . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Price (Per Night): RS. ' . number_format($priceLKR, 2) . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Price (Per Night): USD. ' . number_format($priceUSD, 2) . ' </p>';
                        $availableRoomDetails .= '<p class="card-text small"> Price (Per Night): EURO. ' . number_format($priceEU, 2) . ' </p>';

                        $availableRoomDetails .= '</div>';
                        $availableRoomDetails .= '</div>';
                        $availableRoomDetails .= '</div>';
                        $availableRoomDetails .= '</div>';
                    }
                    $availableRoomDetails .= '</div>';
                }
            }

            return response()->json([
                'roomTypeDetails' => $roomTypeDetails,
                'availableRoomDetails' => $availableRoomDetails
            ]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }



    /**
     * Get Room Details
     */
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

    /**
     * Get Customer Details
     */
    public function getBookingCustomers(Request $request)
    {
        $id = $request['id'];
        $customer = Customer::find($id);

        $html = '<table class="table" cellspacing="0" cellpadding="0">';
        $html .= '<tr>';
        $html .= '<td>Name :</td>';
        $html .= '<td>' . $customer->name . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Contact No :</td>';
        $html .= '<td>' . $customer->contact . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Email :</td>';
        $html .= '<td>' . $customer->email . '</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td>Address :</td>';
        $html .= '<td>' . $customer->address . '</td>';
        $html .= '</tr>';
        $html .= '</table>';

        return response()->json([$html]);
    }



    // public function status()
    // {

    //     $title = 'Room Status';

    //     $type = RoomType::all();


    //     $data = Room::all();
    //     $data1 = Booking::all();
    //     $breadcrumbs = [
    //         // ['label' => 'First Level', 'url' => '', 'active' => false],
    //         ['label' => $title, 'url' => '', 'active' => true],
    //     ];

    //  return view('pos.bookings.roomstatus', compact('data', 'title', 'breadcrumbs', 'type', 'data1'));
    // }


    public function status(Request $request)
    {
        $title = 'Room Status';
        $type = RoomType::all();

        // Retrieve the check-in and check-out dates from the request
        $checkin_date = $request->input('checkin_date');
        $checkout_date = $request->input('checkout_date');

        // Check if both check-in and check-out dates are provided
        if ($checkin_date && $checkout_date) {
            // Fetch rooms that are not booked for the entered dates
            $data = Room::whereDoesntHave('bookings', function ($query) use ($checkin_date, $checkout_date) {
                $query->where(function ($q) use ($checkin_date, $checkout_date) {
                    $q->where('checkin', '<', $checkout_date)
                        ->where('checkout', '>', $checkin_date);
                });
            })->get();
        } else {
            // If check-in and check-out dates are not provided, return all rooms
            $data = Room::all();
        }

        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

     return view('pos.bookings.roomstatus', compact('data', 'title', 'breadcrumbs', 'type'));
    }



    public function bookingReport()
    {
        $title = 'Booking Report';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        $data = Booking::all();
     return view('pos.reports.bookingReports', compact('data'));
    }


    public function updateCancelReason(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        try {
            // Find the booking by ID
            $booking = Booking::findOrFail($id);


            $booking->cancel_reason = $request->cancel_reason;


            $booking->save();

            return response()->json(['success' => true, 'message' => 'Cancel reason updated successfully'], 200);
        } catch (\Exception $e) {

            return response()->json(['success' => false, 'message' => 'Failed to update cancel reason'], 500);
        }
    }


    public function updateDates(Request $request)
    {
        Log::info('Starting updateDates method', ['request' => $request->all()]);

        try {
            $request->validate([
                'booking_id' => 'required|exists:bookings,id',
                'checkin_date' => 'required|date',
                'checkout_date' => 'required|date|after:checkin_date',
            ]);
            Log::info('Validation passed');

            $bookingId = $request->booking_id;
            $newCheckin = $request->checkin_date;
            $newCheckout = $request->checkout_date;

            Log::info('Processing booking dates update', [
                'booking_id' => $bookingId,
                'new_checkin' => $newCheckin,
                'new_checkout' => $newCheckout
            ]);

            // Fetch the booking and its associated rooms
            $booking = Booking::findOrFail($bookingId);
            Log::info('Booking found', ['booking' => $booking->toArray()]);

            $bookedRoomIds = $booking->rooms()->pluck('rooms.id')->toArray();
            Log::info('Booked room IDs', ['room_ids' => $bookedRoomIds]);

            // Check for conflicting bookings
            $conflictingBookings = Booking::where('id', '!=', $bookingId)
                ->whereIn('id', function ($query) use ($bookedRoomIds) {
                    $query->select('booking_id')
                        ->from('bookings_rooms')
                        ->whereIn('room_id', $bookedRoomIds);
                })
                ->where(function ($query) use ($newCheckin, $newCheckout) {
                    $query->where(function ($q) use ($newCheckin, $newCheckout) {
                        $q->where('checkin', '<', $newCheckout)
                            ->where('checkout', '>', $newCheckin);
                    });
                })
                ->exists();

            Log::info('Conflict check completed', ['has_conflicts' => $conflictingBookings]);

            if ($conflictingBookings) {
                Log::warning('Date conflict detected', [
                    'booking_id' => $bookingId,
                    'new_dates' => [$newCheckin, $newCheckout]
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'The selected dates conflict with another booking for one or more of the booked rooms.',
                ], 422);
            }

            // Update the booking dates
            DB::beginTransaction();
            Log::info('Transaction started');

            try {
                $updateData = [
                    'checkin' => $newCheckin,
                    'checkout' => $newCheckout,
                    'updated_by' => auth()->id(),
                ];

                $booking->update($updateData);
                Log::info('Booking dates updated', ['update_data' => $updateData]);

                // Update checkincheckout table if necessary
                if ($booking->checkincheckout) {
                    $booking->checkincheckout()->update([
                        'checkin' => $newCheckin,
                        'checkout' => $newCheckout,
                    ]);
                    Log::info('CheckinCheckout records updated');
                } else {
                    Log::warning('No checkincheckout records found for booking', ['booking_id' => $bookingId]);
                }

                DB::commit();
                Log::info('Transaction committed');

                return response()->json([
                    'success' => true,
                    'message' => 'Booking dates updated successfully.',
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error updating booking dates', [
                    'booking_id' => $bookingId,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the booking.',
                    'error' => $e->getMessage()
                ], 500);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Unexpected error in updateDates', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
