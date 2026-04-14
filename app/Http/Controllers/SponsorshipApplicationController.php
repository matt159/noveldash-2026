<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSponsorshipApplicationRequest;
use App\Models\SponsorshipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SponsorshipApplicationController extends Controller
{
    public function create(): View
    {
        return view('sponsorship.apply');
    }

    public function store(StoreSponsorshipApplicationRequest $request): RedirectResponse
    {
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
