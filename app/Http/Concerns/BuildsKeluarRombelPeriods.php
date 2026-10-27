<?php

namespace App\Http\Concerns;

use App\Models\KeluarRombel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait BuildsKeluarRombelPeriods
{
    private function selectedAcademicPeriod(Request $request): ?array
    {
        $validated = $request->validate([
            'academic_year' => ['nullable', 'required_with:semester', 'regex:/^\d{4}\/\d{4}$/'],
            'semester' => ['nullable', 'required_with:academic_year', 'in:GANJIL,GENAP'],
        ]);

        if (empty($validated['academic_year']) || empty($validated['semester'])) {
            return null;
        }

        return [
            'year' => $validated['academic_year'],
            'semester' => $validated['semester'],
        ];
    }

    private function availableAcademicPeriods(Builder $query): Collection
    {
        return $query
            ->select(['academic_year', 'semester'])
            ->selectRaw('COUNT(*) as record_count')
            ->whereNotNull('academic_year')
            ->whereNotNull('semester')
            ->groupBy('academic_year', 'semester')
            ->orderByDesc('academic_year')
            ->orderBy('semester')
            ->get();
    }

    private function recordsForAcademicPeriod(Builder $query, array $period): Builder
    {
        return $query
            ->where('academic_year', $period['year'])
            ->where('semester', $period['semester']);
    }

    private function groupKeluarRombelByClass(Builder $query): Collection
    {
        return $query->with(['siswa.rombel'])->get()->groupBy(
            fn (KeluarRombel $record) => $record->siswa?->rombel?->nama_kelas ?? 'Tidak Ada Kelas'
        );
    }
}
