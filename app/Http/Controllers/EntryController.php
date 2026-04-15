<?php

namespace App\Http\Controllers;

use App\Enums\EntryRound;
use App\Enums\EntryRoundStatus;
use App\Enums\PaymentStatus;
use App\Mail\EntryConfirmationMail;
use App\Models\Entry;
use App\Models\SponsorshipCode;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\StripeClient;

class EntryController extends Controller
{
    private function prizeIsOpen(): bool
    {
        $opening = config('dates.prize_opening_date');
        $closing = config('dates.prize_closing_date');

        if (! $opening || ! $closing) {
            return true;
        }

        $today = Carbon::today();

        return $today->between(Carbon::parse($opening), Carbon::parse($closing));
    }

    public function create(): View
    {
        return view('entry.create', ['isOpen' => $this->prizeIsOpen()]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (! $this->prizeIsOpen()) {
            abort(403, 'Entries are currently closed.');
        }

        if ($request->input('genre') === 'Other' && $request->filled('genre_other')) {
            $request->merge(['genre' => $request->input('genre_other')]);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'novel_title' => ['required', 'string', 'max:255'],
            'genre' => ['required', 'string', 'max:255'],
            'manuscript' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:'.config('submission.manuscript_upload_limit')],
            'sensitive_subjects' => ['nullable', 'string', 'max:2000'],
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

        do {
            $uid = strtoupper(Str::random(8));
        } while (Entry::where('uid', $uid)->exists());

        $manuscript = $request->file('manuscript');
        $manuscriptFilename = $uid.'-'.$manuscript->getClientOriginalName();
        $manuscriptPath = $manuscript->storeAs('manuscripts', $manuscriptFilename, 'spaces');

        $entry = Entry::create([
            'uid' => $uid,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'novel_title' => $validated['novel_title'],
            'genre' => $validated['genre'],
            'sensitive_subjects' => $validated['sensitive_subjects'] ?? null,
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
