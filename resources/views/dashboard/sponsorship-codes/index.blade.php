<x-dashboard-layout title="Sponsorship Codes">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sponsorship Codes</h1>
        <form action="{{ route('dashboard.sponsorship-codes.generate') }}" method="POST">
            @csrf
            <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700 transition-colors">
                Generate Code
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($codes->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No sponsorship codes yet. Generate one above.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Used By</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Used At</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($codes as $code)
                        <tr>
                            <td class="px-4 py-3 font-mono text-sm font-medium text-gray-900 tracking-widest">{{ $code->code }}</td>
                            <td class="px-4 py-3">
                                @if ($code->isUsed())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">Used</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-700">Available</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                @if ($code->entry)
                                    <a href="{{ route('dashboard.entries.show', $code->entry) }}" class="hover:underline">
                                        {{ $code->entry->name }}
                                    </a>
                                    <span class="text-gray-400 text-xs ml-1">({{ $code->entry->email }})</span>
                                @else
                                    <span class="text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $code->used_at?->format('d M Y H:i') ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $code->created_at->format('d M Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($codes->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $codes->links() }}</div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
