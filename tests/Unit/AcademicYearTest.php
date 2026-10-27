<?php

namespace Tests\Unit;

use App\Support\AcademicYear;
use Carbon\Carbon;
use Tests\TestCase;

class AcademicYearTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_academic_year_changes_on_july_seventh(): void
    {
        Carbon::setTestNow('2026-07-06 12:00:00');
        $this->assertSame(
            ['year' => '2025/2026', 'status' => 'GENAP'],
            AcademicYear::current()
        );

        Carbon::setTestNow('2026-07-07 12:00:00');
        $this->assertSame(
            ['year' => '2026/2027', 'status' => 'GANJIL'],
            AcademicYear::current()
        );
    }

    public function test_academic_year_remains_current_after_july(): void
    {
        Carbon::setTestNow('2026-08-01 12:00:00');

        $this->assertSame(
            ['year' => '2026/2027', 'status' => 'GANJIL'],
            AcademicYear::current()
        );
    }

    public function test_academic_period_can_be_resolved_from_a_historical_record_date(): void
    {
        $this->assertSame(
            ['year' => '2024/2025', 'status' => 'GANJIL'],
            AcademicYear::forDate('2024-07-07 00:00:00')
        );
        $this->assertSame(
            ['year' => '2023/2024', 'status' => 'GENAP'],
            AcademicYear::forDate('2024-07-06 16:59:59')
        );
        $this->assertSame(
            ['year' => '2024/2025', 'status' => 'GANJIL'],
            AcademicYear::forDate('2024-07-06 17:00:00')
        );
    }
}
