<x-layout title="Submit Your Entry">
    <div class="min-h-screen flex items-start justify-center pt-12 pb-20 px-4">
        <div class="w-full max-w-xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ config('submission.title') }}</h1>
                <p class="mt-2 text-gray-600">{{ config('submission.description') }}</p>
                <p class="mt-1 text-sm text-gray-500">Entry fee: £{{ number_format(config('submission.price') / 100, 2) }}</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form method="POST" action="{{ route('entry.store') }}" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('phone') border-red-400 @enderror">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="manuscript" class="block text-sm font-medium text-gray-700 mb-1">Manuscript <span class="text-red-500">*</span></label>
                        <input type="file" id="manuscript" name="manuscript" required accept=".pdf,.doc,.docx"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 file:mr-3 file:rounded file:border-0 file:bg-gray-100 file:px-3 file:py-1 file:text-xs file:font-medium @error('manuscript') border-red-400 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX. Max 50MB.</p>
                        @error('manuscript')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sponsorship_code" class="block text-sm font-medium text-gray-700 mb-1">Sponsorship Code <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" id="sponsorship_code" name="sponsorship_code" value="{{ old('sponsorship_code') }}"
                            placeholder="e.g. ABCD-EFGH-IJKL"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('sponsorship_code') border-red-400 @enderror">
                        <p class="mt-1 text-xs text-gray-500">If you have a sponsorship code, entry is free of charge.</p>
                        @error('sponsorship_code')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-colors">
                        Submit Entry &rarr;
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
