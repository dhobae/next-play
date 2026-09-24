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
        Schema::create('season', function (Blueprint $table) {
            $table->id();
            $table->string('nama_season');
            $table->string('mp');
            $table->string('w');
            $table->string('l');
            $table->string('pp');
            $table->string('lp');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });

        Schema::table('atlet_riwayat_turnamen', function (Blueprint $table) {
            $table->foreign('season_id')->references('id')->on('season')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atlet_riwayat_turnamen', function (Blueprint $table) {
            $table->dropForeign(['season_id']);
        });
        Schema::dropIfExists('season');
    }
};
