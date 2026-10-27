<?php

namespace Tests\Helpers;

/**
 * Centralised login helpers for smoke / authorisation tests.
 *
 * The per-role login endpoints already set BOTH the Auth guard and the
 * session keys (admin_id, walas_id, kakom_id, kepsek_id, kurikulum_id,
 * siswa_id) that the application's own middleware + controller guards rely
 * on, so re-using the real login flow (instead of faking a guard) produces
 * a faithful session for protected-route assertions.
 */
trait LoginUser
{
    protected function loginAdmin(): void
    {
        $this->post('/loginadmin', ['nama' => 'admin', 'password' => '12345678']);
    }

    protected function loginWalas(): void
    {
        $this->post('/logingtk', ['nama' => 'walas', 'password' => '12345678']);
    }

    protected function loginKakom(): void
    {
        $this->post('/loginkaprog', ['nama' => 'kakom', 'password' => '12345678']);
    }

    protected function loginKepsek(): void
    {
        $this->post('/loginkepsek', ['nama' => 'kepsek', 'password' => '12345678']);
    }

    protected function loginKurikulum(): void
    {
        $this->post('/loginkurikulum', ['nama' => 'kurikulum', 'password' => '12345678']);
    }

    protected function loginSiswa(): void
    {
        $this->post('/loginsiswa', ['nama_siswa' => 'siswa', 'password' => '12345678']);
    }

    /** Login the user for the given role into the same test instance. */
    protected function loginAsRole(string $role): void
    {
        match ($role) {
            'admin'      => $this->loginAdmin(),
            'walas'      => $this->loginWalas(),
            'kakom'      => $this->loginKakom(),
            'kepsek'     => $this->loginKepsek(),
            'kurikulum'  => $this->loginKurikulum(),
            'siswa'      => $this->loginSiswa(),
            default      => throw new \InvalidArgumentException("unknown role {$role}"),
        };
    }
}
