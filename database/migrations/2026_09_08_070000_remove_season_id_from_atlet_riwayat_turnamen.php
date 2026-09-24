<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('atlet_riwayat_turnamen', function (Blueprint $table): void {
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');
        });
    }

    public function down(): void
    {
        Schema::table('atlet_riwayat_turnamen', function (Blueprint $table): void {
            $table->unsignedBigInteger('season_id')->nullable();
            $table->foreign('season_id')->references('id')->on('season')->nullOnDelete();
        });
    }
};