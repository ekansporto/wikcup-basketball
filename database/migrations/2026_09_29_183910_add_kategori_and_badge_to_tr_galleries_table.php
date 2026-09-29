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
        Schema::table('tr_galleries', function (Blueprint $table) {
            $table->string('kategori', 50)->nullable()->default('Pertandingan')->after('caption');
            $table->string('badge_text', 50)->nullable()->after('kategori');
            $table->string('tag_text', 100)->nullable()->after('badge_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tr_galleries', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'badge_text', 'tag_text']);
        });
    }
};
