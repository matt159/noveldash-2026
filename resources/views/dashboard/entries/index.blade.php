<x-dashboard-layout title="All Entries">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">All Entries</h1>
        <span class="text-sm text-gray-500">{{ $entries->total() }} total</span>
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

    <div class="mb-4 flex flex-wrap gap-2">
        @php
            $filters = [
                null => 'All',
                'paid' => 'Paid',
                'sponsored' => 'Sponsored',
                'manually_confirmed' => 'Manually confirmed',
                'unconfirmed' => 'Unconfirmed',
            ];
        @endphp
        @foreach ($filters as $value => $label)
            <a href="{{ route('dashboard.entries.index', $value ? ['payment' => $value] : []) }}"
                class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors
                    {{ $paymentFilter === $value
                        ? 'bg-gray-900 text-white'
                        : 'bg-white border border-gray-300 text-gray-600 hover:bg-gray-50' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($entries->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No entries yet.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Round</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($entries as $entry)
                        <tr class="{{ ! $entry->isPaid() ? 'bg-amber-50 hover:bg-amber-100' : 'hover:bg-gray-50' }}">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $entry->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $entry->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $entry->email }}</td>
                            <td class="px-4 py-3">
                                @if (! $entry->isPaid())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                        No payment captured
                                    </span>
                                @elseif ($entry->isManuallyConfirmed())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        Manually confirmed
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $entry->payment_status->badgeClass() }}">
                                        {{ $entry->payment_status->label() }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $entry->current_round?->label() ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($entry->round_status)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $entry->round_status->badgeClass() }}">
                                        {{ $entry->round_status->label() }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $entry->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    @if (! $entry->isPaid())
                                        <form action="{{ route('dashboard.entries.confirm-payment', $entry) }}" method="POST"
                                            onsubmit="return confirm('Manually confirm payment for {{ addslashes($entry->name) }}?')">
                                            @csrf
                                            <button type="submit" class="text-sm font-medium text-amber-700 hover:underline">
                                                Confirm Payment
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('dashboard.entries.show', $entry) }}" class="text-sm font-medium text-gray-900 hover:underline">View</a>
                                    <form action="{{ route('dashboard.entries.destroy', $entry) }}" method="POST"
                                        onsubmit="return confirm('Delete entry for {{ addslashes($entry->name) }}? This can be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($entries->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $entries->links() }}</div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
