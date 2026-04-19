<?php

namespace App\Http\Controllers;

use App\Enums\EntryRound;
use App\Enums\EntryRoundStatus;
use App\Enums\PaymentStatus;
use App\Mail\EntryConfirmationMail;
use App\Models\Entry;
use App\Models\SponsoredPlace;
use App\Models\SponsorshipCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

        // Check if this is a sponsored place payment
        $sponsoredPlace = SponsoredPlace::where('stripe_session_id', $sessionId)->first();

        if ($sponsoredPlace) {
            if ($sponsoredPlace->payment_status === PaymentStatus::Pending) {
                $stripe = new StripeClient(config('services.stripe.secret'));
                $session = $stripe->checkout->sessions->retrieve($sessionId);

                if ($session->payment_status === 'paid') {
                    $sponsoredPlace->update([
                        'payment_status' => PaymentStatus::Completed,
                    ]);

                    $code = strtoupper(Str::random(4).'-'.Str::random(4).'-'.Str::random(4));

                    SponsorshipCode::create([
                        'code' => $code,
                        'sponsored_place_id' => $sponsoredPlace->id,
                    ]);
                }
            }

            return redirect()->route('sponsored-space.thanks');
        }

        // Fall through to entry payment handling
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

    public function stripeWebhookSuccess(Request $request): JsonResponse
    {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $event = $stripe->events->retrieve($request->input('event_id'));
        $session = $event->data->object;
        $metadata = $session->metadata;

        if (($metadata->source ?? null) !== 'noveldash') {
            return response()->json(['status' => 'ignored'], 200);
        }

        $type = $metadata->type ?? null;

        if ($type === 'entry') {
            $entry = Entry::where('stripe_session_id', $session->id)->first();

            if (! $entry || $entry->payment_status === PaymentStatus::Completed) {
                return response()->json(['status' => 'ok'], 200);
            }

            $entry->update([
                'payment_status' => PaymentStatus::Completed,
                'stripe_payment_intent_id' => $session->payment_intent,
                'current_round' => EntryRound::Round1,
                'round_status' => EntryRoundStatus::Active,
            ]);

            Mail::to($entry->email)->send(new EntryConfirmationMail($entry));
        } elseif ($type === 'sponsored_place') {
            $sponsoredPlace = SponsoredPlace::where('stripe_session_id', $session->id)->first();

            if (! $sponsoredPlace || $sponsoredPlace->payment_status === PaymentStatus::Completed) {
                return response()->json(['status' => 'ok'], 200);
            }

            $sponsoredPlace->update([
                'payment_status' => PaymentStatus::Completed,
            ]);

            $code = strtoupper(Str::random(4).'-'.Str::random(4).'-'.Str::random(4));

            SponsorshipCode::create([
                'code' => $code,
                'sponsored_place_id' => $sponsoredPlace->id,
            ]);
        }

        return response()->json(['status' => 'ok'], 200);
    }
}
