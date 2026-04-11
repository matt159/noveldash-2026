<x-layout title="Payment Cancelled">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="text-5xl mb-6">✕</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Payment Cancelled</h1>
            <p class="text-gray-600 mb-6">Your payment was cancelled and your entry has not been submitted.</p>
            <a href="{{ route('entry.create') }}" class="inline-block rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition-colors">
                Try Again
            </a>
        </div>
    </div>
</x-layout>
