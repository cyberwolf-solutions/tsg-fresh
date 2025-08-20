<?php

namespace App\Http\Controllers;

use App\Models\Biller;
use Illuminate\Http\Request;

class BillerController extends Controller
{
     public function index() {
        $title = 'Biller';

        $breadcrumbs = [
            // ['label' => 'First Level', 'url' => '', 'active' => false],
            ['label' => $title, 'url' => '', 'active' => true],
        ];
        // $data = Biller::all();
     return view('pos.biller.index', compact('title', 'breadcrumbs'));
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
    public function show(Biller $biller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Biller $biller)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Biller $biller)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Biller $biller)
    {
        //
    }
}
