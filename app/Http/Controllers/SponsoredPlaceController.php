<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSponsoredPlaceRequest;
use App\Models\SponsoredPlace;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SponsoredPlaceController extends Controller
{
    public function create(): View
    {
        return view('sponsorship.sponsored-space');
    }

    public function store(StoreSponsoredPlaceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        SponsoredPlace::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'twitter_handle' => $validated['twitter_handle'] ?? null,
            'publish_details' => isset($validated['publish_details']) && $validated['publish_details'],
        ]);

        return redirect()->route('sponsored-space.thanks');
    }

    public function thanks(): View
    {
        return view('sponsorship.sponsored-space-thanks');
    }
}
