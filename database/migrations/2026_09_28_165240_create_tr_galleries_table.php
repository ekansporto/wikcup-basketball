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
        Schema::create('tr_galleries', function (Blueprint $table) {
            $table->bigIncrements('id_gallery');
            $table->unsignedBigInteger('id_match')->nullable();
            $table->string('foto', 255);
            $table->text('caption')->nullable();
            $table->date('tanggal');
            $table->timestamps();

            $table->foreign('id_match')
                  ->references('id_match')
                  ->on('tr_matches')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_galleries');
    }
};
