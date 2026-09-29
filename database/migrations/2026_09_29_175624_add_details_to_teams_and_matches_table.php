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
        Schema::table('ms_teams', function (Blueprint $table) {
            $table->string('nickname', 50)->nullable()->after('nama_tim');
            $table->string('singkatan', 10)->nullable()->after('nickname');
            $table->string('warna', 20)->nullable()->after('singkatan');
        });

        Schema::table('tr_matches', function (Blueprint $table) {
            $table->string('fase', 100)->nullable()->default('Fase Grup & Penyisihan')->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_teams', function (Blueprint $table) {
            $table->dropColumn(['nickname', 'singkatan', 'warna']);
        });

        Schema::table('tr_matches', function (Blueprint $table) {
            $table->dropColumn(['fase']);
        });
    }
};
