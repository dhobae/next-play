<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('atlet_riwayat_turnamen', function (Blueprint $table) {
            $table->string('hasil_turnamen')->change();
        });
    }

    public function down(): void
    {
        Schema::table('atlet_riwayat_turnamen', function (Blueprint $table) {
            $table->enum('hasil_turnamen', [
                'Champions',
                'Runner Up',
                'R32',
                'R16',
                'R8',
                'R4',
                'Kualifikasi',
            ])->change();
        });
    }
};
