<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSponsorshipApplicationRequest;
use App\Models\SponsorshipApplication;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SponsorshipApplicationController extends Controller
{
    private function prizeIsOpen(): bool
    {
        $opening = config('dates.prize_opening_date');
        $closing = config('dates.prize_closing_date');

        if(auth()->check()){
            return true;
        }

        if (! $opening || ! $closing) {
            return true;
        }

        $today = Carbon::today();

        return $today->between(Carbon::parse($opening), Carbon::parse($closing));
    }

    public function create(): View
    {
        return view('sponsorship.apply', ['isOpen' => $this->prizeIsOpen()]);
    }

    public function store(StoreSponsorshipApplicationRequest $request): RedirectResponse
    {
        if (! $this->prizeIsOpen()) {
            abort(403, 'Applications are currently closed.');
        }

        $validated = $request->validated();

        $documentPath = null;
        if ($request->hasFile('supporting_document')) {
            $documentPath = $request->file('supporting_document')->store('sponsorship-documents', 'spaces');
        }

        SponsorshipApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'reason' => $validated['reason'],
            'supporting_document_path' => $documentPath,
        ]);

        return redirect()->route('sponsorship.applied');
    }

    public function applied(): View
    {
        return view('sponsorship.applied');
    }
}
