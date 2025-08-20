<?php

namespace App\Http\Controllers;

use App\Models\CashInHand;
use App\Models\OrderPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashInHandController extends Controller
{

     public function openModal()
    {
        $today = now()->format('Y-m-d');
        $cashInHand = CashInHand::where('date', $today)->first();

        // Calculate total cash received today from orders_payments
        $totalCashReceived = OrderPayment::whereDate('date', $today)
            ->where('payment_type', 'Cash')
            ->sum('total');

        return response()->json([
            'success' => true,
            'data' => [
                'opening_cash' => $cashInHand?->opening_cash ?? 0,
                'closing_cash' => $cashInHand?->closing_cash ?? 0,
                'total_cash_received' => $totalCashReceived,
                'balance' => $cashInHand?->balance ?? 0,
            ]
        ]);
    }

    public function save(Request $request)
    {
        $request->validate([
            'opening_cash' => 'required|numeric|min:0',
            'closing_cash' => 'required|numeric|min:0',
        ]);

        $today = now()->format('Y-m-d');
        $totalCashReceived = OrderPayment::whereDate('date', $today)
            ->where('payment_type', 'Cash')
            ->sum('total');

        $balance = $request->closing_cash - ($request->opening_cash + $totalCashReceived);

        $cash = CashInHand::updateOrCreate(
            ['date' => $today],
            [
                'opening_cash' => $request->opening_cash,
                'closing_cash' => $request->closing_cash,
                'total_cash_received' => $totalCashReceived,
                'balance' => $balance,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Cash in hand saved successfully!',
            'balance' => $balance
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(CashInHand $cashInHand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CashInHand $cashInHand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CashInHand $cashInHand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CashInHand $cashInHand)
    {
        //
    }
}
