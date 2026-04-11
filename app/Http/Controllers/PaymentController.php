<?php

namespace App\Http\Controllers;

use App\Enums\EntryRound;
use App\Enums\EntryRoundStatus;
use App\Enums\PaymentStatus;
use App\Mail\EntryConfirmationMail;
use App\Models\Entry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function success(Request $request): View|RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('entry.create');
        }

        $entry = Entry::where('stripe_session_id', $sessionId)->first();

        if (! $entry) {
            return redirect()->route('entry.create');
        }

        if ($entry->payment_status === PaymentStatus::Pending) {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $session = $stripe->checkout->sessions->retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $entry->update([
                    'payment_status' => PaymentStatus::Completed,
                    'stripe_payment_intent_id' => $session->payment_intent,
                    'current_round' => EntryRound::Round1,
                    'round_status' => EntryRoundStatus::Active,
                ]);

                Mail::to($entry->email)->send(new EntryConfirmationMail($entry));
            }
        }

        return view('entry.success');
    }

    public function cancel(): View
    {
        return view('entry.cancel');
    }
}
