<x-dashboard-layout title="Sponsorship Applications">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Sponsorship Applications</h1>
        <span class="text-sm text-gray-500">{{ $applications->total() }} total</span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if ($applications->isEmpty())
            <div class="px-6 py-12 text-center text-gray-500 text-sm">No sponsorship applications yet.</div>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($applications as $application)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $application->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $application->email }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $application->status->badgeClass() }}">
                                    {{ $application->status->label() }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $application->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('dashboard.sponsorship-applications.show', $application) }}" class="text-sm font-medium text-gray-900 hover:underline">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($applications->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">{{ $applications->links() }}</div>
            @endif
        @endif
    </div>
</x-dashboard-layout>
