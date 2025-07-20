<?php

namespace App\Http\Controllers;

use App\Models\Bot;
use App\Models\Order;
use App\Models\Product;
use App\Models\SetMenu;
use Illuminate\Http\Request;

class BarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $type = $request->type;


        $title = 'Beverage Order Tickets';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];

        
        // $data = Order::where('status', 'Pending')
        // ->whereHas('items.product', function ($query) {
        //     $query->where('type', 'BOT');
        // });


        $data = Order::where('status', 'Pending')
            ->where(function ($query) {
                $query->whereHas('items', function ($query) {
                    $query->whereHasMorph('itemable', [Product::class, SetMenu::class], function ($query) {
                        $query->where('type', 'KOT');
                    });
                });
            });

        if ($type) {
            $data = $data->where('type', $type);
        }

        $data = $data->get();

     return view('pos.bot.index', compact('title', 'breadcrumbs', 'data', 'type'));
    }
    public function print(string $id)
    {
        $data = Order::where('id', $id)
        ->whereHas('items', function ($query) {
            $query->where(function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('type', 'KOT');
                })->orWhereHas('setmenu', function ($query) {
                    $query->where('type', 'KOT');
                });
            });
        })
        ->first();
     return view('pos.bot.print', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
