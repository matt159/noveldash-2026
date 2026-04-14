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
                        <label for="novel_title" class="block text-sm font-medium text-gray-700 mb-1">Novel Title <span class="text-red-500">*</span></label>
                        <input type="text" id="novel_title" name="novel_title" value="{{ old('novel_title') }}" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('novel_title') border-red-400 @enderror">
                        @error('novel_title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre <span class="text-red-500">*</span></label>
                        <select id="genre" name="genre" required
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('genre') border-red-400 @enderror"
                            onchange="document.getElementById('genre_other_wrap').classList.toggle('hidden', this.value !== 'Other')">
                            <option value="" disabled {{ old('genre') ? '' : 'selected' }}>Select a genre&hellip;</option>
                            @foreach ([
                                'Crime/Thriller', 'Cozy Mystery', 'Historical Fiction', 'Ghost Story',
                                'Horror', 'YA', 'Romance', 'Science Fiction', 'Fantasy',
                                'Literary Fiction', 'Time Travel', 'Dystopia', 'Magical Realism',
                                'Memoir', 'Fictional Memoir', 'Book Club', 'Commercial Fiction',
                                'Uplit', 'Other',
                            ] as $genre)
                                <option value="{{ $genre }}" {{ old('genre') === $genre ? 'selected' : '' }}>{{ $genre }}</option>
                            @endforeach
                        </select>
                        @error('genre')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror

                        <div id="genre_other_wrap" class="{{ old('genre') === 'Other' ? '' : 'hidden' }} mt-2">
                            <input type="text" id="genre_other" name="genre_other" value="{{ old('genre_other') }}"
                                placeholder="Please specify your genre"
                                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent">
                        </div>
                    </div>

                    <div>
                        <label for="manuscript" class="block text-sm font-medium text-gray-700 mb-1">Manuscript <span class="text-red-500">*</span></label>
                        <input type="file" id="manuscript" name="manuscript" required accept=".pdf,.doc,.docx"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 file:mr-3 file:rounded file:border-0 file:bg-gray-100 file:px-3 file:py-1 file:text-xs file:font-medium @error('manuscript') border-red-400 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Accepted formats: PDF, DOC, DOCX. Max 10MB.</p>
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

                    <div>
                        <label for="sensitive_subjects" class="block text-sm font-medium text-gray-700 mb-1">Sensitive Subjects <span class="text-gray-400 font-normal">(optional)</span></label>
                        <p class="mb-2 text-xs text-gray-500">Does your work include graphic sexual violence, animal cruelty, racism, misogyny, bullying or other sensitive subjects? Please state in the box below.</p>
                        <textarea id="sensitive_subjects" name="sensitive_subjects" rows="4"
                            class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent @error('sensitive_subjects') border-red-400 @enderror">{{ old('sensitive_subjects') }}</textarea>
                        @error('sensitive_subjects')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border border-gray-200 rounded-lg p-5 space-y-4">
                        <p class="text-sm font-semibold text-gray-800">Before submitting, please confirm all of the following:</p>

                        @php
                            $checklist = [
                                'checklist_anonymised' => 'Have you anonymised your manuscript? Your name MUST NOT appear in your manuscript, header, footer or filename!',
                                'checklist_rules' => 'I have read and understood the Rules of Entry on the Cheshire Novel Prize website.',
                                'checklist_word_count' => 'My submission consists of the first 5,000 words of my manuscript followed by a 500 word synopsis.',
                                'checklist_word_doc' => 'I am submitting a Word doc.',
                                'checklist_line_spacing' => 'All of my text in both my manuscript and synopsis is set with double line spacing.',
                                'checklist_font' => 'I have used Times New Roman font throughout.',
                                'checklist_font_size' => 'I have all text set to size 12 font.',
                                'checklist_feedback' => 'I understand that Cheshire Novel Prize offers feedback as part of the entry fee which is generic feedback with a paragraph of personal feedback and this is not a detailed editorial report.',
                            ];
                        @endphp

                        @foreach ($checklist as $fieldName => $label)
                            <label class="flex items-start gap-3 cursor-pointer group">
                                <input type="checkbox" name="{{ $fieldName }}" id="{{ $fieldName }}" required
                                    class="checklist-item mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer">
                                <span class="text-sm text-gray-700 leading-snug group-hover:text-gray-900">{{ $label }}</span>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit" id="submit-btn" disabled
                        class="w-full rounded-lg bg-gray-900 px-4 py-3 text-sm font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition-colors disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-gray-900">
                        Submit Entry &rarr;
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
