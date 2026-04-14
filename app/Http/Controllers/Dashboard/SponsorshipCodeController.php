<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SponsorshipCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SponsorshipCodeController extends Controller
{
    public function index(): View
    {
        $codes = SponsorshipCode::with(['entry', 'sponsoredPlace'])
            ->latest()
            ->paginate(50);

        return view('dashboard.sponsorship-codes.index', compact('codes'));
    }

    public function generate(): RedirectResponse
    {
        $code = strtoupper(Str::random(4).'-'.Str::random(4).'-'.Str::random(4));

        SponsorshipCode::create(['code' => $code]);

        return back()->with('success', "Sponsorship code {$code} generated.");
    }
}
