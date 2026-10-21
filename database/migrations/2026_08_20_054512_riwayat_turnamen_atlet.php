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
        Schema::create('atlet_riwayat_turnamen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atlet_id')
                ->constrained('atlet')
                ->cascadeOnDelete();

                $table->unsignedBigInteger('season_id');
                    
            $table->string('nama_turnamen');
            $table->date('tanggal_turnamen');
            $table->string('hasil_turnamen');
            $table->integer('poin_turnamen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atlet_riwayat_turnamen');
    }
};
