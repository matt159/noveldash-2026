<?php

return [
    'title' => env('SUBMISSION_TITLE', 'Novel Prize Entry'),
    'description' => env('SUBMISSION_DESCRIPTION', 'Entry fee'),
    'price' => (int) env('SUBMISSION_PRICE', 1500),
];
