<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Http\Requests\StoreSponsoredPlaceRequest;
use App\Models\SponsoredPlace;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Stripe\StripeClient;

class SponsoredPlaceController extends Controller
{
    public function create(): View
    {
        return view('sponsorship.sponsored-space');
    }

    public function store(StoreSponsoredPlaceRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $place = SponsoredPlace::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'twitter_handle' => $validated['twitter_handle'] ?? null,
            'publish_details' => isset($validated['publish_details']) && $validated['publish_details'],
            'payment_status' => PaymentStatus::Pending,
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'gbp',
                    'product_data' => [
                        'name' => 'Sponsored Place for Cheshire Novel Prize',
                    ],
                    'unit_amount' => config('submission.price'),
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'customer_email' => $place->email,
            'metadata' => [
                'source' => 'noveldash',
                'type' => 'sponsored_entry',
                'sponsored_place_id' => $place->id,
            ],
        ]);

        $place->update(['stripe_session_id' => $session->id]);

        return redirect($session->url, 303);
    }

    public function thanks(): View
    {
        return view('sponsorship.sponsored-space-thanks');
    }
}
