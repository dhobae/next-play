<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('season_klub', function (Blueprint $table) {
            $table->integer('mp')->default(0)->change();
            $table->integer('w')->default(0)->change();
            $table->integer('l')->default(0)->change();
            $table->integer('pp')->default(0)->change();
            $table->integer('lp')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('season_klub', function (Blueprint $table) {
            $table->unsignedInteger('mp')->default(0)->change();
            $table->unsignedInteger('w')->default(0)->change();
            $table->unsignedInteger('l')->default(0)->change();
            $table->unsignedInteger('pp')->default(0)->change();
            $table->unsignedInteger('lp')->default(0)->change();
        });
    }
};