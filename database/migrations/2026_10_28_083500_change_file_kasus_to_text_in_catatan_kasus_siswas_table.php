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
        Schema::table('catatan_kasus_siswas', function (Blueprint $table) {
            $table->text('file_kasus')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_kasus_siswas', function (Blueprint $table) {
            $table->string('file_kasus', 255)->nullable()->change();
        });
    }
};
