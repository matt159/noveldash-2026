<?php

use App\Models\Entry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Entry::whereNull('uid')->each(function (Entry $entry) {
            do {
                $uid = strtoupper(Str::random(8));
            } while (Entry::where('uid', $uid)->exists());

            $entry->update(['uid' => $uid]);
        });
    }

    public function down(): void {}
};
