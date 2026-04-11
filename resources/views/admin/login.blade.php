<x-layout title="Admin Login">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="w-full max-w-sm">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">{{ config('submission.title') }}</h1>
                <p class="mt-1 text-sm text-gray-500">Dashboard Login</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 @error('email') border-red-400 @enderror">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition-colors">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
