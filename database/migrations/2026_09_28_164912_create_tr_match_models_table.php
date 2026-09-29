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
        Schema::create('tr_matches', function (Blueprint $table) {
            $table->bigIncrements('id_match');
            $table->unsignedBigInteger('team_a_id');
            $table->unsignedBigInteger('team_b_id');
            $table->date('tanggal');
            $table->time('jam');
            $table->string('lokasi', 100);
            $table->unsignedInteger('skor_tim_a')->nullable();
            $table->unsignedInteger('skor_tim_b')->nullable();
            $table->timestamps();

            $table->foreign('team_a_id')
                  ->references('id_team')
                  ->on('ms_teams')
                  ->onDelete('cascade');

            $table->foreign('team_b_id')
                  ->references('id_team')
                  ->on('ms_teams')
                  ->onDelete('cascade');

            // Constraint: team_a_id tidak boleh sama dengan team_b_id
            // MySQL/MariaDB tidak mendukung CHECK constraint langsung via Blueprint,
            // sehingga digunakan DB::statement untuk menambahkannya secara manual.
        });

        // Tambahkan CHECK constraint jika database mendukung (MySQL 8.0.16+ / MariaDB 10.2.1+)
        if (config('database.default') === 'mysql') {
            \DB::statement('ALTER TABLE tr_matches ADD CONSTRAINT chk_teams_different CHECK (team_a_id <> team_b_id)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_matches');
    }
};
