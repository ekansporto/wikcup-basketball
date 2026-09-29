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
        Schema::create('ms_players', function (Blueprint $table) {
            $table->bigIncrements('id_player');
            $table->unsignedBigInteger('id_user')->unique()->nullable();
            $table->unsignedBigInteger('id_team')->nullable();
            $table->string('nama', 100);
            $table->unsignedInteger('no_punggung');
            $table->string('posisi', 50);
            $table->string('foto', 255)->nullable();
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();
            $table->string('kelas_program', 100)->nullable();
            $table->boolean('is_captain')->default(false);
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('ms_users')
                  ->onDelete('set null');

            $table->foreign('id_team')
                  ->references('id_team')
                  ->on('ms_teams')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_players');
    }
};
