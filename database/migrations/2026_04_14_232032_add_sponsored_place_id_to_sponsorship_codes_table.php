<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sponsorship_codes', function (Blueprint $table) {
            $table->foreignId('sponsored_place_id')->nullable()->after('entry_id')->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sponsorship_codes', function (Blueprint $table) {
            $table->dropForeign(['sponsored_place_id']);
            $table->dropColumn('sponsored_place_id');
        });
    }
};
