<x-layout title="Pay for a Sponsorship">
    <div class="min-h-screen flex items-start justify-center pt-12 pb-20 px-4">
        <div class="w-full max-w-xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ config('submission.title') }}</h1>
                <p class="mt-2 text-gray-600">Pay for a sponsored place</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <p class="text-gray-700 mb-6">Thank you for sponsoring our entrants for Cheshire Novel Prize. We really appreciate it.</p>

                <form method="POST" action="{{ route('sponsored-space.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
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
                        <label for="twitter_handle" class="block text-sm font-medium text-gray-700 mb-1">Twitter Handle <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" id="twitter_handle" name="twitter_handle" value="{{ old('twitter_handle') }}"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('twitter_handle') border-red-400 @enderror">
                        @error('twitter_handle')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="publish_details" id="publish_details" value="1" {{ old('publish_details') ? 'checked' : '' }}
                                class="mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                            <span class="text-sm text-gray-700 leading-snug group-hover:text-gray-900">I agree to you publishing my sponsorship details on the website.</span>
                        </label>
                        @error('publish_details')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-colors">
                        Submit &rarr;
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
