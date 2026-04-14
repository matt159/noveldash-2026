<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SponsoredPlace;
use Illuminate\View\View;

class SponsoredPlaceController extends Controller
{
    public function index(): View
    {
        $sponsoredPlaces = SponsoredPlace::latest()->paginate(50);

        return view('dashboard.sponsored-places.index', compact('sponsoredPlaces'));
    }
}
