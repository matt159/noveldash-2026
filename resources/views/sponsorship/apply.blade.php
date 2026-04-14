<x-layout title="Apply for a Sponsored Place">
    <div class="min-h-screen flex items-start justify-center pt-12 pb-20 px-4">
        <div class="w-full max-w-xl">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ config('submission.title') }}</h1>
                <p class="mt-2 text-gray-600">Apply for a Sponsored Place</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form method="POST" action="{{ route('sponsorship.apply.store') }}" enctype="multipart/form-data" class="space-y-5">
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
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('phone') border-red-400 @enderror">
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Reason for Sponsored Place <span class="text-red-500">*</span></label>
                        <textarea id="reason" name="reason" rows="6" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('reason') border-red-400 @enderror">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supporting_document" class="block text-sm font-medium text-gray-700 mb-1">Upload Supporting Information <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="file" id="supporting_document" name="supporting_document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 file:mr-3 file:rounded file:border-0 file:bg-gray-100 file:px-3 file:py-1 file:text-xs file:font-medium @error('supporting_document') border-red-400 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX, JPG, PNG. Max 4MB.</p>
                        @error('supporting_document')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 space-y-4">
                        <p class="text-sm font-semibold text-gray-800">Please confirm all of the following before submitting:</p>

                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="checklist_criteria" id="checklist_criteria" required
                                class="checklist-item mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                            <span class="text-sm text-gray-700 leading-snug group-hover:text-gray-900">I have read and understood the sponsored place criteria.</span>
                        </label>
                        @error('checklist_criteria')
                            <p class="text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="checklist_novel_ready" id="checklist_novel_ready" required
                                class="checklist-item mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                            <span class="text-sm text-gray-700 leading-snug group-hover:text-gray-900">My novel is ready to enter.</span>
                        </label>
                        @error('checklist_novel_ready')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" name="checklist_48_hours" id="checklist_48_hours" required
                                class="checklist-item mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                            <span class="text-sm text-gray-700 leading-snug group-hover:text-gray-900">If approved I will enter my novel in the next 48 hours or risk my place being cancelled.</span>
                        </label>
                        @error('checklist_48_hours')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" id="submit-btn" disabled
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-colors disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-gray-900">
                        Submit Application &rarr;
                    </button>

                    <script>
                        (function () {
                            const checkboxes = document.querySelectorAll('.checklist-item');
                            const submitBtn = document.getElementById('submit-btn');

                            function updateSubmitState() {
                                submitBtn.disabled = !Array.from(checkboxes).every(cb => cb.checked);
                            }

                            checkboxes.forEach(cb => cb.addEventListener('change', updateSubmitState));
                        })();
                    </script>
                </form>
            </div>
        </div>
    </div>
</x-layout>
