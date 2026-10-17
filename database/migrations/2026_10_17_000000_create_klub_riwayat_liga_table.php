<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('klub_riwayat_liga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('klub_id')->constrained('klub')->cascadeOnDelete();
            $table->string('nama_liga');
            $table->string('hasil_liga');
            $table->date('tanggal_liga');
            $table->integer('poin_liga');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('klub_riwayat_liga');
    }
};