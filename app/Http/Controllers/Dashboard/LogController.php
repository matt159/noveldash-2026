<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(): View
    {
        $logPath = storage_path('logs/laravel.log');
        $entries = [];

        if (File::exists($logPath)) {
            $contents = File::get($logPath);

            preg_match_all(
                '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] \S+\.(\w+): (.+?)(?=\[\d{4}-\d{2}-\d{2}|\z)/s',
                $contents,
                $matches,
                PREG_SET_ORDER
            );

            foreach (array_reverse($matches) as $match) {
                $entries[] = [
                    'timestamp' => $match[1],
                    'level' => strtolower($match[2]),
                    'message' => trim($match[3]),
                ];
            }

            $entries = array_slice($entries, 0, 10);
        }

        return view('dashboard.log.index', compact('entries'));
    }
}
