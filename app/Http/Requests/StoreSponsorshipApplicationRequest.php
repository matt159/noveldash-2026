<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSponsorshipApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'reason' => ['required', 'string', 'max:5000'],
            'supporting_document' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:4096'],
            'checklist_criteria' => ['accepted'],
            'checklist_novel_ready' => ['accepted'],
            'checklist_48_hours' => ['accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'checklist_criteria.accepted' => 'You must confirm you have read and understood the sponsored place criteria.',
            'checklist_novel_ready.accepted' => 'You must confirm your novel is ready to enter.',
            'checklist_48_hours.accepted' => 'You must confirm you will enter within 48 hours if approved.',
        ];
    }
}
