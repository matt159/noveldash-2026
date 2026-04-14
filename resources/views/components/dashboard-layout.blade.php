<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} — {{ config('submission.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 font-sans">
    @php
        $allEntriesCount = \App\Models\Entry::count();
        $round1Count = \App\Models\Entry::whereIn('current_round', ['round1', 'top100', 'longlist', 'shortlist'])->count();
        $top100Count = \App\Models\Entry::whereIn('current_round', ['top100', 'longlist', 'shortlist'])->count();
        $longlistCount = \App\Models\Entry::whereIn('current_round', ['longlist', 'shortlist'])->count();
        $shortlistCount = \App\Models\Entry::where('current_round', 'shortlist')->count();
        $sponsorshipCodesCount = \App\Models\SponsorshipCode::count();
        $sponsorshipApplicationsCount = \App\Models\SponsorshipApplication::count();
        $sponsoredPlacesCount = \App\Models\SponsoredPlace::count();
    @endphp
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-6">
                    <span class="font-semibold text-gray-900">{{ config('submission.title') }}</span>
                    <a href="{{ route('dashboard.entries.index') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->routeIs('dashboard.entries.*') ? 'font-medium text-gray-900' : '' }}">All Entries ({{ $allEntriesCount }})</a>
                    <a href="{{ route('dashboard.rounds.show', 'round1') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->is('dashboard/rounds/round1') ? 'font-medium text-gray-900' : '' }}">Round 1 ({{ $round1Count }})</a>
                    <a href="{{ route('dashboard.rounds.show', 'top100') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->is('dashboard/rounds/top100') ? 'font-medium text-gray-900' : '' }}">Top 100 ({{ $top100Count }})</a>
                    <a href="{{ route('dashboard.rounds.show', 'longlist') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->is('dashboard/rounds/longlist') ? 'font-medium text-gray-900' : '' }}">Longlist ({{ $longlistCount }})</a>
                    <a href="{{ route('dashboard.rounds.show', 'shortlist') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->is('dashboard/rounds/shortlist') ? 'font-medium text-gray-900' : '' }}">Shortlist ({{ $shortlistCount }})</a>
                    <a href="{{ route('dashboard.sponsorship-codes.index') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->routeIs('dashboard.sponsorship-codes.*') ? 'font-medium text-gray-900' : '' }}">Sponsorship Codes ({{ $sponsorshipCodesCount }})</a>
                    <a href="{{ route('dashboard.sponsorship-applications.index') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->routeIs('dashboard.sponsorship-applications.*') ? 'font-medium text-gray-900' : '' }}">Sponsorship Applications ({{ $sponsorshipApplicationsCount }})</a>
                    <a href="{{ route('dashboard.sponsored-places.index') }}" class="text-sm text-gray-600 hover:text-gray-900 {{ request()->routeIs('dashboard.sponsored-places.*') ? 'font-medium text-gray-900' : '' }}">Sponsored Places ({{ $sponsoredPlacesCount }})</a>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{ $slot }}
    </main>
</body>
</html>
