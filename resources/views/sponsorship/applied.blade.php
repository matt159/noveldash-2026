<x-layout title="Application Received">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="text-center max-w-md">
            <div class="text-5xl mb-6">✓</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Application Received!</h1>
            <p class="text-gray-600 mb-2">Thank you for applying for a sponsored place in <strong>{{ config('submission.title') }}</strong>.</p>
            <p class="text-gray-500 text-sm">We will review your application and be in touch by email with a decision.</p>
        </div>
    </div>
</x-layout>
