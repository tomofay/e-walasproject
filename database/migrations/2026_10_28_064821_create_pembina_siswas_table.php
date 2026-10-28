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
        Schema::create('pembina_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('nip', 50)->nullable();
            $table->string('no_wa', 20)->nullable();
            $table->string('password', 255);
            $table->string('image_url', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembina_siswas');
    }
};
