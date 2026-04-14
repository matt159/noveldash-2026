<x-dashboard-layout :title="$sponsorshipApplication->name">
    <div class="mb-6">
        <a href="{{ route('dashboard.sponsorship-applications.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; All Applications</a>
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
        {{-- Application Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Application Details</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sponsorshipApplication->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sponsorshipApplication->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sponsorshipApplication->phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $sponsorshipApplication->status->badgeClass() }}">
                                {{ $sponsorshipApplication->status->label() }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $sponsorshipApplication->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    @if ($sponsorshipApplication->reviewed_at)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewed By</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $sponsorshipApplication->reviewed_by }} on {{ $sponsorshipApplication->reviewed_at->format('d M Y \a\t H:i') }}
                            </dd>
                        </div>
                    @endif
                    @if ($sponsorshipApplication->sponsorshipCode)
                        <div>
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Sponsorship Code Issued</dt>
                            <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $sponsorshipApplication->sponsorshipCode->code }}</dd>
                        </div>
                    @endif
                    <div class="sm:col-span-2">
                        <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Reason for Sponsored Place</dt>
                        <dd class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $sponsorshipApplication->reason }}</dd>
                    </div>
                    @if ($sponsorshipApplication->supporting_document_path)
                        <div class="sm:col-span-2">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Supporting Document</dt>
                            <dd class="mt-1">
                                <a href="{{ route('dashboard.sponsorship-applications.download', $sponsorshipApplication) }}"
                                    class="inline-flex items-center text-sm font-medium text-gray-900 hover:underline">
                                    Download supporting document
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>

        {{-- Actions --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                @if ($sponsorshipApplication->isPending())
                    <div class="space-y-3">
                        <form action="{{ route('dashboard.sponsorship-applications.approve', $sponsorshipApplication) }}" method="POST"
                            onsubmit="return confirm('Approve this application and send a sponsorship code to {{ addslashes($sponsorshipApplication->email) }}?')">
                            @csrf
                            <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-colors">
                                Approve &amp; Send Code
                            </button>
                        </form>
                        <form action="{{ route('dashboard.sponsorship-applications.decline', $sponsorshipApplication) }}" method="POST"
                            onsubmit="return confirm('Decline this application and notify {{ addslashes($sponsorshipApplication->email) }}?')">
                            @csrf
                            <button type="submit" class="w-full rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-colors">
                                Decline Application
                            </button>
                        </form>
                    </div>
                @else
                    <p class="text-sm text-gray-500">This application has already been {{ $sponsorshipApplication->status->value }}.</p>
                @endif
            </div>
        </div>
    </div>
</x-dashboard-layout>
