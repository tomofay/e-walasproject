<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

class SmokeDiagTest extends TestCase
{
    use LoginUser;

    private function diagnose(string $role, string $uri): void
    {
        $guard = match ($role) {
            'admin' => 'admins',
            'walas' => 'walas',
            'kakom' => 'kakoms',
            'kepsek' => 'kepseks',
            'kurikulum' => 'kurikulums',
            'siswa' => 'siswas',
        };

        if (! Auth::guard($guard)->check()) {
            $this->loginAsRole($role);
        }
        $this->withoutExceptionHandling();
        $res = $this->get($uri);
        fwrite(STDERR, "\n=== $uri [$role] => ".$res->getStatusCode()." ===\n");
        fwrite(STDERR, (string) $res->getContent()."\n");
    }

    public function test_diag(): void
    {
        foreach ([
            ['admin', 'walas/1/edit'],
            ['admin', 'guru/1/edit'],
            ['admin', 'mapel/1/edit'],
            ['admin', 'kakom/1/edit'],
            ['admin', 'kurikulum/1/edit'],
            ['admin', 'rombeldetail/1'],
            ['admin', 'keluarrombeldata/1'],
        ] as [$role, $uri]) {
            $this->diagnose($role, $uri);
        }
        $this->assertTrue(true);
    }
}
