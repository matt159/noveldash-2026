<x-dashboard-layout title="Log">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Log</h1>
        <span class="text-sm text-gray-500">Last {{ count($entries) }} entries</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if (empty($entries))
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No log entries found.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">When</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($entries as $entry)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">{{ $entry['timestamp'] }}</td>
                            <td class="px-4 py-3 text-sm whitespace-nowrap">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    {{ in_array($entry['level'], ['error', 'critical', 'alert', 'emergency']) ? 'bg-red-100 text-red-700' : '' }}
                                    {{ in_array($entry['level'], ['warning']) ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ in_array($entry['level'], ['info', 'notice', 'debug']) ? 'bg-gray-100 text-gray-600' : '' }}
                                ">{{ $entry['level'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                <pre class="whitespace-pre-wrap break-all font-sans">{{ $entry['message'] }}</pre>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-dashboard-layout>
