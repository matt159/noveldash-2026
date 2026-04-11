<?php

namespace App\Http\Controllers;

use App\Enums\EntryRound;
use App\Enums\EntryRoundStatus;
use App\Enums\PaymentStatus;
use App\Mail\EntryConfirmationMail;
use App\Models\Entry;
use App\Models\SponsorshipCode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Stripe\StripeClient;

class EntryController extends Controller
{
    public function create(): View
    {
        return view('entry.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'manuscript' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:51200'],
            'sponsorship_code' => ['nullable', 'string', 'max:100'],
        ]);

        $sponsorshipCode = null;
        if (! empty($validated['sponsorship_code'])) {
            $sponsorshipCode = SponsorshipCode::where('code', $validated['sponsorship_code'])
                ->whereNull('entry_id')
                ->first();

            if (! $sponsorshipCode) {
                return back()->withInput()->withErrors([
                    'sponsorship_code' => 'This sponsorship code is invalid or has already been used.',
                ]);
            }
        }

        $manuscriptPath = $request->file('manuscript')->store('manuscripts', 'spaces');

        $entry = Entry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'manuscript_path' => $manuscriptPath,
            'sponsorship_code_id' => $sponsorshipCode?->id,
            'payment_status' => PaymentStatus::Pending,
        ]);

        if ($sponsorshipCode) {
            $sponsorshipCode->update([
                'entry_id' => $entry->id,
                'used_at' => now(),
            ]);

            $entry->update([
                'payment_status' => PaymentStatus::Sponsored,
                'current_round' => EntryRound::Round1,
                'round_status' => EntryRoundStatus::Active,
            ]);

            Mail::to($entry->email)->send(new EntryConfirmationMail($entry));

            return redirect()->route('entry.success');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => config('submission.title'),
                        'description' => config('submission.description'),
                    ],
                    'unit_amount' => config('submission.price'),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'customer_email' => $entry->email,
            'metadata' => [
                'entry_id' => $entry->id,
            ],
        ]);

        $entry->update(['stripe_session_id' => $session->id]);

        return redirect($session->url, 303);
    }

    public function success(): View
    {
        return view('entry.success');
    }
}
