<x-dashboard-layout title="Revisions">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Revisions</h1>
        <span class="text-sm text-gray-500">{{ $revisions->total() }} total</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($revisions->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No revisions recorded yet.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">When</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Old Value</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">New Value</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($revisions as $revision)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500 whitespace-nowrap">
                                {{ $revision->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                {{ $revision->user_id ? ($users[$revision->user_id]?->name ?? 'Unknown') : '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                {{ class_basename($revision->revisionable_type) }} #{{ $revision->revisionable_id }}
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900 whitespace-nowrap">
                                {{ $revision->fieldName() }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate">
                                {{ $revision->oldValue() ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 max-w-xs truncate">
                                {{ $revision->newValue() ?? '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($revisions->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $revisions->links() }}</div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
