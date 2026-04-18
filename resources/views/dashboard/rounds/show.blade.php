<x-dashboard-layout :title="$currentRound->label()">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $currentRound->label() }}</h1>
        <span class="text-sm text-gray-500">{{ $entries->count() }} entries</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($entries->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No entries in this round yet.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feedback</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($entries as $entry)
                        @php $roundStatus = $entry->statusForRound($currentRound); @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $entry->id }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $entry->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $entry->email }}</td>
                            <td class="px-4 py-3">
                                @if ($entry->genre)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $entry->genreBadgeClass() }}">
                                        {{ $entry->genre }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if ($roundStatus)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $roundStatus->badgeClass() }}">
                                        {{ $roundStatus->label() }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">
                                @if ($entry->feedback_sent_at && $roundStatus?->value === 'failed')
                                    <span class="text-green-600 text-xs">Sent</span>
                                @elseif ($entry->feedback_path && $roundStatus?->value === 'failed')
                                    <span class="text-yellow-600 text-xs">Uploaded</span>
                                @else
                                    <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $entry->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('dashboard.entries.download-manuscript', $entry) }}" class="text-xs text-gray-500 hover:text-gray-900 hover:underline">Download</a>
                                    <a href="{{ route('dashboard.entries.show', $entry) }}" class="text-sm font-medium text-gray-900 hover:underline">View</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-dashboard-layout>
