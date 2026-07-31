<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class SiswaAuthTest extends TestCase
{
    public function test_siswa_can_view_login_page(): void
    {
        $this->get('/loginsiswa')->assertStatus(200);
    }

    public function test_siswa_can_login(): void
    {
        $response = $this->post('/loginsiswa/store', [
            'nama'     => 'Andi Pratama',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/siswapage');
        $this->assertAuthenticated('siswas');
    }

    public function test_siswa_dashboard_accessible(): void
    {
        $this->loginSiswa();
        $this->get('/siswapage')->assertStatus(200);
    }

    public function test_siswa_can_view_biodata(): void
    {
        $this->loginSiswa();
        $this->get('/datadiri')->assertStatus(200);
    }

    public function test_siswa_can_view_catatan_kasus(): void
    {
        $this->loginSiswa();
        $this->get('/catatankasussiswa')->assertStatus(200);
    }

    public function test_siswa_can_view_profil(): void
    {
        $this->loginSiswa();
        $this->get('/profilesiswa')->assertStatus(200);
    }

    public function test_siswa_logout(): void
    {
        $this->loginSiswa();
        $this->assertAuthenticated('siswas');

        $this->post('/homepagesiswa/logout')->assertRedirect('/');
        $this->assertGuest('siswas');
    }

    private function loginSiswa(): void
    {
        $this->post('/loginsiswa/store', [
            'nama'     => 'Andi Pratama',
            'password' => $this->password(),
        ]);
    }
}
