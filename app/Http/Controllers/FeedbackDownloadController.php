<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FeedbackDownloadController extends Controller
{
    public function download(string $token): StreamedResponse
    {
        $entry = Entry::where('feedback_token', $token)->firstOrFail();

        abort_unless($entry->feedback_path, 404);

        $extension = pathinfo($entry->feedback_path, PATHINFO_EXTENSION) ?: 'pdf';

        return Storage::disk('spaces')->download(
            $entry->feedback_path,
            Str::slug($entry->name).'-feedback.'.$extension
        );
    }
}
