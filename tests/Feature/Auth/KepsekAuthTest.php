<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class KepsekAuthTest extends TestCase
{
    public function test_kepsek_can_login(): void
    {
        $response = $this->post('/loginkepsek/store', [
            'nama'     => 'Drs. H. Ahmad Fauzi, M.Pd.',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/homepagekepsek');
        $this->assertAuthenticated('kepseks');
    }

    public function test_kepsek_dashboard_accessible(): void
    {
        $this->loginKepsek();
        $this->get('/kepsekpage')->assertStatus(200);
    }

    public function test_kepsek_can_view_walas(): void
    {
        $this->loginKepsek();
        $this->get('/kepsekwalas')->assertStatus(200);
    }

    public function test_kepsek_can_view_rombel(): void
    {
        $this->loginKepsek();
        $this->get('/kepsekrombel')->assertStatus(200);
    }

    public function test_kepsek_can_view_adm_walas(): void
    {
        $this->loginKepsek();
        $this->get('/admwalasviewkepsek')->assertStatus(200);
    }

    public function test_kepsek_logout(): void
    {
        $this->loginKepsek();
        $this->assertAuthenticated('kepseks');

        $this->post('/homepagekepsek/logout')->assertRedirect('/');
        $this->assertGuest('kepseks');
    }

    private function loginKepsek(): void
    {
        $this->post('/loginkepsek/store', [
            'nama'     => 'Drs. H. Ahmad Fauzi, M.Pd.',
            'password' => $this->password(),
        ]);
    }
}
