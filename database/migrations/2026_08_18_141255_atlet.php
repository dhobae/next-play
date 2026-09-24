<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('atlet', function (Blueprint $table) {
            $table->id();
            $table->string('nama_atlet');
            $table->string('foto_atlet');
            $table->enum('level', [
                'Bronze',
                'Silver',
                'Elektrum',
                'Beginner',
            ]);
            $table->tinyInteger('jenis_kelamin'); // 0 laki laki 1 perempuan
            // $table->string('klub_asosiasi');
            // yang baru :
            $table->unsignedBigInteger('klub_id');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('kebangsaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atlet');
    }
};
