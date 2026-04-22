<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Dashboard\EntryController as DashboardEntryController;
use App\Http\Controllers\Dashboard\LogController;
use App\Http\Controllers\Dashboard\RevisionController;
use App\Http\Controllers\Dashboard\RoundController;
use App\Http\Controllers\Dashboard\SponsoredPlaceController as DashboardSponsoredPlaceController;
use App\Http\Controllers\Dashboard\SponsorshipApplicationController as DashboardSponsorshipApplicationController;
use App\Http\Controllers\Dashboard\SponsorshipCodeController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FeedbackDownloadController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SponsoredPlaceController;
use App\Http\Controllers\SponsorshipApplicationController;
use App\Http\Middleware\AdminAuth;
use App\Models\Entry;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

// Sponsorship payment
Route::get('/sponsored-space', [SponsoredPlaceController::class, 'create'])->name('sponsored-space.create');
Route::post('/sponsored-space', [SponsoredPlaceController::class, 'store'])->name('sponsored-space.store');
Route::get('/sponsored-space/thanks', [SponsoredPlaceController::class, 'thanks'])->name('sponsored-space.thanks');

// Sponsorship applications
Route::get('/sponsorship-apply', [SponsorshipApplicationController::class, 'create'])->name('sponsorship.apply');
Route::post('/sponsorship-apply', [SponsorshipApplicationController::class, 'store'])->name('sponsorship.apply.store');
Route::get('/sponsorship-apply/thanks', [SponsorshipApplicationController::class, 'applied'])->name('sponsorship.applied');

// Submission
Route::get('/regular-entry', [EntryController::class, 'create'])->name('entry.create');
Route::post('/enter', [EntryController::class, 'store'])->name('entry.store');
Route::get('/entry/success', [EntryController::class, 'success'])->name('entry.success');

// Stripe payment callbacks
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/stripe/payment-success-webhook', [PaymentController::class, 'stripeWebhookSuccess'])->name('payment.stripe-webhook-success');

// Feedback download (public, token-gated)
Route::get('/feedback/{token}', [FeedbackDownloadController::class, 'download'])->name('feedback.download');

// Admin login
Route::get('/admin/login', [AdminLoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Dashboard (protected)
Route::middleware(AdminAuth::class)->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::redirect('/', '/dashboard/entries');

    Route::get('/entries', [DashboardEntryController::class, 'index'])->name('entries.index');
    Route::get('/entries/{entry}', [DashboardEntryController::class, 'show'])->name('entries.show');
    Route::get('/entries/{entry}/download-manuscript', [DashboardEntryController::class, 'downloadManuscript'])->name('entries.download-manuscript');
    Route::post('/entries/{entry}/pass', [DashboardEntryController::class, 'pass'])->name('entries.pass');
    Route::post('/entries/{entry}/fail', [DashboardEntryController::class, 'fail'])->name('entries.fail');
    Route::post('/entries/{entry}/upload-feedback', [DashboardEntryController::class, 'uploadFeedback'])->name('entries.upload-feedback');
    Route::post('/entries/{entry}/send-feedback', [DashboardEntryController::class, 'sendFeedback'])->name('entries.send-feedback');
    Route::post('/entries/{entry}/confirm-payment', [DashboardEntryController::class, 'confirmPayment'])->name('entries.confirm-payment');
    Route::patch('/entries/{entry}/genre', [DashboardEntryController::class, 'updateGenre'])->name('entries.update-genre');
    Route::delete('/entries/{entry}', [DashboardEntryController::class, 'destroy'])->name('entries.destroy');

    Route::get('/rounds/{round}', [RoundController::class, 'show'])->name('rounds.show');

    Route::get('/sponsorship-codes', [SponsorshipCodeController::class, 'index'])->name('sponsorship-codes.index');
    Route::post('/sponsorship-codes/generate', [SponsorshipCodeController::class, 'generate'])->name('sponsorship-codes.generate');

    Route::get('/sponsorship-applications', [DashboardSponsorshipApplicationController::class, 'index'])->name('sponsorship-applications.index');
    Route::get('/sponsorship-applications/{sponsorshipApplication}', [DashboardSponsorshipApplicationController::class, 'show'])->name('sponsorship-applications.show');
    Route::get('/sponsorship-applications/{sponsorshipApplication}/download', [DashboardSponsorshipApplicationController::class, 'downloadDocument'])->name('sponsorship-applications.download');
    Route::post('/sponsorship-applications/{sponsorshipApplication}/approve', [DashboardSponsorshipApplicationController::class, 'approve'])->name('sponsorship-applications.approve');
    Route::post('/sponsorship-applications/{sponsorshipApplication}/decline', [DashboardSponsorshipApplicationController::class, 'decline'])->name('sponsorship-applications.decline');

    Route::get('/sponsored-places', [DashboardSponsoredPlaceController::class, 'index'])->name('sponsored-places.index');

    Route::get('/revisions', [RevisionController::class, 'index'])->name('revisions.index');

    Route::get('/log', [LogController::class, 'index'])->name('log.index');

});

Route::middleware(AdminAuth::class)->group(function () {

    Route::get('preview-confirmation-email', function () {
        $entry = Entry::latest()->first();

        return view('emails.entry-confirmation', compact('entry'));
    });

});
