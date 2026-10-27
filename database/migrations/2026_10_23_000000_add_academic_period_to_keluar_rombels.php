<?php

use App\Support\AcademicYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('keluar_rombels', function (Blueprint $table) {
            $table->string('academic_year', 9)->nullable();
            $table->string('semester', 10)->nullable();
        });

        DB::table('keluar_rombels')
            ->select(['id', 'created_at'])
            ->orderBy('id')
            ->chunkById(200, function ($records): void {
                foreach ($records as $record) {
                    $period = AcademicYear::forDate($record->created_at);
                    DB::table('keluar_rombels')
                        ->where('id', $record->id)
                        ->update([
                            'academic_year' => $period['year'],
                            'semester' => $period['status'],
                        ]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('keluar_rombels', function (Blueprint $table) {
            $table->dropColumn(['academic_year', 'semester']);
        });
    }
};
