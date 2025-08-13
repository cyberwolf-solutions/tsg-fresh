<?php

namespace App\Http\Controllers;

use App\Models\LandingItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\landing_page_sections;

class LandingController extends Controller
{
    //
    public function index()
    {
        $sections = landing_page_sections::with(['items' => function ($query) {
            $query->where('is_active', true)->orderBy('order');
        }])->where('is_active', true)->get();

        return view('landing-page.home', compact('sections'));
    }
}
