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
        Schema::create('klub', function (Blueprint $table) {
            $table->id();
             $table->string('nama_klub');
             $table->text('alamat')->nullable(); // textarea
             $table->string('gambar');
            $table->timestamps();
        });

        Schema::table('atlet', function (Blueprint $table) {
            $table->foreign('klub_id')->references('id')->on('klub')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atlet', function (Blueprint $table) {
            $table->dropForeign(['klub_id']);
        });
        Schema::dropIfExists('klub');
    }
};
