<x-dashboard-layout :title="$entry->name">
    <div class="mb-6">
        <a href="{{ route('dashboard.entries.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; All Entries</a>
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Entry Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Entry Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Entry ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $entry->uid }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $entry->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $entry->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $entry->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $entry->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Current Round</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $entry->current_round?->label() ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Round Status</dt>
                        <dd class="mt-1">
                            @if ($entry->round_status)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $entry->round_status->badgeClass() }}">
                                    {{ $entry->round_status->label() }}
                                </span>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </dd>
                    </div>
                    @if ($entry->sponsorshipCode)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sponsorship Code</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $entry->sponsorshipCode->code }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Payment Info --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment</h2>

                @if (! $entry->isPaid())
                    <div class="mb-4 rounded-lg bg-amber-50 border border-amber-200 px-4 py-3 text-sm text-amber-800">
                        No payment has been captured for this entry.
                    </div>
                @endif

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</dt>
                        <dd class="mt-1">
                            @if ($entry->isManuallyConfirmed())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    Manually confirmed
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $entry->payment_status->badgeClass() }}">
                                    {{ $entry->payment_status->label() }}
                                </span>
                            @endif
                        </dd>
                    </div>
                    @if ($entry->isManuallyConfirmed())
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Confirmed By</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $entry->manually_confirmed_by }} on {{ $entry->manually_confirmed_at->format('d M Y \a\t H:i') }}
                            </dd>
                        </div>
                    @endif
                    @if ($entry->stripe_session_id)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Stripe Session ID</dt>
                            <dd class="mt-1 text-xs text-gray-600 font-mono break-all">{{ $entry->stripe_session_id }}</dd>
                        </div>
                    @endif
                    @if ($stripePayment)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Amount Paid</dt>
                            <dd class="mt-1 text-sm text-gray-900">£{{ number_format($stripePayment->amount_received / 100, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Intent</dt>
                            <dd class="mt-1 text-xs text-gray-600 font-mono break-all">{{ $stripePayment->id }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

            {{-- Feedback --}}
            @if ($entry->round_status?->value === 'failed')
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Feedback</h2>

                    @if ($entry->feedback_path)
                        <div class="mb-4 flex items-center gap-3 p-3 rounded-lg bg-green-50 border border-green-200">
                            <span class="text-green-700 text-sm">✓ Feedback file uploaded</span>
                            <a href="{{ route('feedback.download', $entry->feedback_token) }}" target="_blank"
                                class="text-xs font-medium text-green-700 underline hover:text-green-900">
                                Download
                            </a>
                            @if ($entry->feedback_sent_at)
                                <span class="text-xs text-green-600 ml-auto">Sent {{ $entry->feedback_sent_at->format('d M Y H:i') }}</span>
                            @endif
                        </div>
                    @endif

                    <form action="{{ route('dashboard.entries.upload-feedback', $entry) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Feedback File</label>
                        <div class="flex gap-2">
                            <input type="file" name="feedback" accept=".pdf,.doc,.docx" required
                                class="flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                            <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700 transition-colors">Upload</button>
                        </div>
                        @error('feedback')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </form>

                    @if ($entry->feedback_path)
                        <form action="{{ route('dashboard.entries.send-feedback', $entry) }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 transition-colors">
                                {{ $entry->feedback_sent_at ? 'Resend Feedback Email' : 'Send Feedback Email' }}
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                <div class="space-y-3">
                    @if (! $entry->isPaid())
                        <form action="{{ route('dashboard.entries.confirm-payment', $entry) }}" method="POST"
                            onsubmit="return confirm('Manually confirm payment for this entry?')">
                            @csrf
                            <button type="submit" class="w-full rounded-lg bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 transition-colors">
                                Manually Confirm Payment
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('dashboard.entries.download-manuscript', $entry) }}"
                        class="flex items-center justify-center w-full rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        Download Manuscript
                    </a>

                    @if ($entry->round_status?->value === 'active' && $entry->current_round?->next())
                        <form action="{{ route('dashboard.entries.pass', $entry) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                                Pass to {{ $entry->current_round->next()->label() }}
                            </button>
                        </form>
                    @endif

                    @if ($entry->round_status?->value === 'active')
                        <form action="{{ route('dashboard.entries.fail', $entry) }}" method="POST"
                            onsubmit="return confirm('Mark this entry as failed?')">
                            @csrf
                            <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                                Fail Entry
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
