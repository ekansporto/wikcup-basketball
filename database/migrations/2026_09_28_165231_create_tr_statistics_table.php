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
        Schema::create('tr_statistics', function (Blueprint $table) {
            $table->bigIncrements('id_statistic');
            $table->unsignedBigInteger('id_player');
            $table->unsignedBigInteger('id_match');
            $table->time('minutes')->default('00:00:00');
            $table->unsignedInteger('poin')->default(0);
            $table->unsignedInteger('rebound')->default(0);
            $table->unsignedInteger('assist')->default(0);
            $table->unsignedInteger('steal')->default(0);
            $table->unsignedInteger('block')->default(0);
            $table->unsignedInteger('turnover')->default(0);
            $table->unsignedInteger('fgm')->default(0);
            $table->unsignedInteger('fga')->default(0);
            $table->unsignedInteger('three_point_made')->default(0);
            $table->unsignedInteger('three_point_attempted')->default(0);
            $table->unsignedInteger('two_point_made')->default(0);
            $table->unsignedInteger('two_point_attempted')->default(0);
            $table->unsignedInteger('free_throw_made')->default(0);
            $table->unsignedInteger('free_throw_attempted')->default(0);
            $table->unsignedInteger('defensive_rebound')->default(0);
            $table->unsignedInteger('foul')->default(0);
            $table->integer('plus_minus')->default(0);
            $table->timestamps();

            $table->unique(['id_player', 'id_match']);

            $table->foreign('id_player')
                  ->references('id_player')
                  ->on('ms_players')
                  ->onDelete('cascade');

            $table->foreign('id_match')
                  ->references('id_match')
                  ->on('tr_matches')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_statistics');
    }
};
