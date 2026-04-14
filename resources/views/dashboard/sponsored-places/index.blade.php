<x-dashboard-layout title="Sponsored Places">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sponsored Places</h1>
        <span class="text-sm text-gray-500">{{ $sponsoredPlaces->total() }} total</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($sponsoredPlaces->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No sponsored places yet.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Twitter</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publish Details</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($sponsoredPlaces as $place)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $place->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $place->email }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $place->twitter_handle ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if ($place->publish_details)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Yes</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $place->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($sponsoredPlaces->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $sponsoredPlaces->links() }}</div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
