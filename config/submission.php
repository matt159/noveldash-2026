<?php

return [
    'title' => env('SUBMISSION_TITLE', 'Novel Prize Entry'),
    'description' => env('SUBMISSION_DESCRIPTION', 'Entry fee'),
    'price' => (int) env('SUBMISSION_PRICE', 1500),
    'manuscript_upload_limit' => (int) env('MANUSCRIPT_UPLOAD_LIMIT', 10240),
    'feedback_upload_limit' => (int) env('FEEDBACK_UPLOAD_LIMIT', 8192),
];
