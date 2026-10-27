<?php

namespace App\Support;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

class AcademicYear
{
    public static function current(): array
    {
        return self::forDate(CarbonImmutable::now('Asia/Jakarta'));
    }

    public static function forDate(CarbonInterface|string|null $date): array
    {
        $today = $date instanceof CarbonInterface
            ? CarbonImmutable::instance($date)->setTimezone('Asia/Jakarta')
            : CarbonImmutable::parse($date ?? 'now', config('app.timezone', 'UTC'))
                ->setTimezone('Asia/Jakarta');
        $year = $today->year;
        $startsThisYear = $today->month > 7
            || ($today->month === 7 && $today->day >= 7);

        if ($startsThisYear) {
            return [
                'year' => "{$year}/".($year + 1),
                'status' => 'GANJIL',
            ];
        }

        return [
            'year' => ($year - 1)."/{$year}",
            'status' => 'GENAP',
        ];
    }
}
