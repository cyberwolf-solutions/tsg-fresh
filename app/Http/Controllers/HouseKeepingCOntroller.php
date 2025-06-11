<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Inventory;
use App\Models\Housekeeping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HouseKeepingCOntroller extends Controller
{
    //

    public function index()
    {
        $title = 'Housekeeping';

        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        // Retrieve rooms where status is 'cleaning'
        $data = Room::where('status', 'Cleaning')->get();

        return view('housekeeping.index', compact('title', 'breadcrumbs', 'data'));
    }


    public function edit(String $id)
    {
        $title = 'Housekeeping';

        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        // Retrieve the room with the given ID
        $data = Room::find($id);
        $items = Inventory::all();
        // $is_edit = true;

        return view('housekeeping.create-edit', compact('title', 'breadcrumbs', 'data', 'items'));
    }

    public function store(Request $request)
    {
        $roomNo = $request->input('roomno');
        $st = $request->input('st');
        $et = $request->input('et');

        // $tableData = $request->input('table_data');
        $tableData = json_decode($request->input('table_data'), true);

        try {
            if ($tableData) {
                foreach ($tableData as $data) {
                    $name = $data['name'];
                    $quantity = $data['quantity'];

                    $inventoryItem = Inventory::where('name', $name)->first();

                    if ($inventoryItem) {

                        $inventoryItem->quantity -= $quantity;

                        if ($inventoryItem->quantity < 0) {
                            $inventoryItem->quantity = 0;
                        }
                        $inventoryItem->save();
                    }
                }
            }

            $room = Room::where('room_no', $roomNo)->first();
            $roomid = $room->id;
            if ($room) {
                $room->status = 'Available';
                $room->save();
            }

            $data = [
                'room_id' => $roomid,
                'start_time'=>$st,
                'end_time'=>$et,

                'created_by' => Auth::user()->id,
            ];

            $housekeeping = Housekeeping::create($data);

            return json_encode(['success' => true, 'message' => 'Houskeeping Finished', 'url' => route('housekeeping.index')]);
        } catch (\Throwable $th) {
            //throw $th;
            return json_encode(['success' => false, 'message' => 'Something went wrong!' . $th]);
        }
    }


    public function view()
    {
        $title = 'Housekeeping History';

        $breadcrumbs = [
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        // Retrieve housekeeping data
        $data = Housekeeping::all();

        return view('housekeeping.history', compact('title', 'breadcrumbs', 'data'));
    }
}
