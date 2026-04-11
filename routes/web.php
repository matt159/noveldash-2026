<?php

use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\Dashboard\EntryController as DashboardEntryController;
use App\Http\Controllers\Dashboard\RoundController;
use App\Http\Controllers\Dashboard\SponsorshipCodeController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\FeedbackDownloadController;
use App\Http\Controllers\PaymentController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Route;

// Submission
Route::get('/regular-entry', [EntryController::class, 'create'])->name('entry.create');
Route::post('/enter', [EntryController::class, 'store'])->name('entry.store');
Route::get('/entry/success', [EntryController::class, 'success'])->name('entry.success');

// Stripe payment callbacks
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

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

    Route::get('/rounds/{round}', [RoundController::class, 'show'])->name('rounds.show');

    Route::get('/sponsorship-codes', [SponsorshipCodeController::class, 'index'])->name('sponsorship-codes.index');
    Route::post('/sponsorship-codes/generate', [SponsorshipCodeController::class, 'generate'])->name('sponsorship-codes.generate');
});
