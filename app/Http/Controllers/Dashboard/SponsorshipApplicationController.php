<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\SponsorshipApplicationStatus;
use App\Http\Controllers\Controller;
use App\Mail\SponsorshipApplicationApprovedMail;
use App\Mail\SponsorshipApplicationDeclinedMail;
use App\Models\SponsorshipApplication;
use App\Models\SponsorshipCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SponsorshipApplicationController extends Controller
{
    public function index(): View
    {
        $applications = SponsorshipApplication::latest()->paginate(50);

        return view('dashboard.sponsorship-applications.index', compact('applications'));
    }

    public function show(SponsorshipApplication $sponsorshipApplication): View
    {
        $sponsorshipApplication->load('sponsorshipCode');

        return view('dashboard.sponsorship-applications.show', compact('sponsorshipApplication'));
    }

    public function approve(SponsorshipApplication $sponsorshipApplication): RedirectResponse
    {
        if (! $sponsorshipApplication->isPending()) {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $code = strtoupper(Str::random(4).'-'.Str::random(4).'-'.Str::random(4));

        $sponsorshipCode = SponsorshipCode::create(['code' => $code]);

        $sponsorshipApplication->update([
            'status' => SponsorshipApplicationStatus::Approved,
            'sponsorship_code_id' => $sponsorshipCode->id,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::user()->name,
        ]);

        Mail::to($sponsorshipApplication->email)->send(
            new SponsorshipApplicationApprovedMail($sponsorshipApplication)
        );

        return back()->with('success', "Application approved and sponsorship code {$code} sent to {$sponsorshipApplication->email}.");
    }

    public function downloadDocument(SponsorshipApplication $sponsorshipApplication): StreamedResponse
    {
        $extension = pathinfo($sponsorshipApplication->supporting_document_path, PATHINFO_EXTENSION) ?: 'pdf';

        return Storage::disk('spaces')->download(
            $sponsorshipApplication->supporting_document_path,
            Str::slug($sponsorshipApplication->name).'-supporting-document.'.$extension
        );
    }

    public function decline(SponsorshipApplication $sponsorshipApplication): RedirectResponse
    {
        if (! $sponsorshipApplication->isPending()) {
            return back()->with('error', 'This application has already been reviewed.');
        }

        $sponsorshipApplication->update([
            'status' => SponsorshipApplicationStatus::Declined,
            'reviewed_at' => now(),
            'reviewed_by' => Auth::user()->name,
        ]);

        Mail::to($sponsorshipApplication->email)->send(
            new SponsorshipApplicationDeclinedMail($sponsorshipApplication)
        );

        return back()->with('success', "Application declined and notification sent to {$sponsorshipApplication->email}.");
    }
}
