<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\EntryRound;
use App\Enums\EntryRoundStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Mail\FeedbackNotificationMail;
use App\Models\Entry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Stripe\StripeClient;

class EntryController extends Controller
{
    public function index(Request $request): View
    {
        $paymentFilter = $request->query('payment');

        $entries = Entry::with('sponsorshipCode')
            ->when($paymentFilter === 'paid', fn ($q) => $q->where('payment_status', PaymentStatus::Completed)->whereNull('manually_confirmed_at'))
            ->when($paymentFilter === 'sponsored', fn ($q) => $q->where('payment_status', PaymentStatus::Sponsored))
            ->when($paymentFilter === 'manually_confirmed', fn ($q) => $q->whereNotNull('manually_confirmed_at'))
            ->when($paymentFilter === 'unconfirmed', fn ($q) => $q->where('payment_status', PaymentStatus::Pending))
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('dashboard.entries.index', compact('entries', 'paymentFilter'));
    }

    public function confirmPayment(Entry $entry): RedirectResponse
    {
        if ($entry->isPaid()) {
            return back()->with('error', 'Payment is already confirmed for this entry.');
        }

        $entry->update([
            'payment_status' => PaymentStatus::Completed,
            'current_round' => EntryRound::Round1,
            'round_status' => EntryRoundStatus::Active,
            'manually_confirmed_at' => now(),
            'manually_confirmed_by' => Auth::user()->name,
        ]);

        return back()->with('success', 'Payment manually confirmed for '.$entry->name.'.');
    }

    public function show(Entry $entry): View
    {
        $entry->load('sponsorshipCode');

        $stripePayment = null;
        if ($entry->stripe_payment_intent_id) {
            $stripe = new StripeClient(config('services.stripe.secret'));
            try {
                $stripePayment = $stripe->paymentIntents->retrieve($entry->stripe_payment_intent_id);
            } catch (\Exception) {
                // Payment intent not retrievable
            }
        }

        return view('dashboard.entries.show', compact('entry', 'stripePayment'));
    }

    public function downloadManuscript(Entry $entry): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $extension = pathinfo($entry->manuscript_path, PATHINFO_EXTENSION) ?: 'pdf';

        return Storage::disk('spaces')->download(
            $entry->manuscript_path,
            Str::slug($entry->name).'-manuscript.'.$extension
        );
    }

    public function pass(Entry $entry): RedirectResponse
    {
        $nextRound = $entry->current_round?->next();

        if (! $nextRound) {
            return back()->with('error', 'Entry is already at the final round.');
        }

        $entry->update([
            'current_round' => $nextRound,
            'round_status' => EntryRoundStatus::Active,
        ]);

        return back()->with('success', "Entry passed to {$nextRound->label()}.");
    }

    public function fail(Entry $entry): RedirectResponse
    {
        $entry->update(['round_status' => EntryRoundStatus::Failed]);

        return back()->with('success', 'Entry marked as failed.');
    }

    public function uploadFeedback(Request $request, Entry $entry): RedirectResponse
    {
        $request->validate([
            'feedback' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:20480'],
        ]);

        if ($entry->feedback_path) {
            Storage::disk('spaces')->delete($entry->feedback_path);
        }

        $path = $request->file('feedback')->store('feedback', 'spaces');

        $entry->update([
            'feedback_path' => $path,
            'feedback_token' => Str::uuid()->toString(),
            'feedback_sent_at' => null,
        ]);

        return back()->with('success', 'Feedback file uploaded.');
    }

    public function sendFeedback(Entry $entry): RedirectResponse
    {
        if (! $entry->feedback_path) {
            return back()->with('error', 'No feedback file uploaded yet.');
        }

        Mail::to($entry->email)->send(new FeedbackNotificationMail($entry));

        $entry->update(['feedback_sent_at' => now()]);

        return back()->with('success', 'Feedback email sent to '.$entry->email.'.');
    }
}
