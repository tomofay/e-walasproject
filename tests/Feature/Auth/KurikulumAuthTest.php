<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class KurikulumAuthTest extends TestCase
{
    public function test_kurikulum_can_login(): void
    {
        $response = $this->post('/loginkurikulum/store', [
            'nama'     => 'Sri Wahyuni, M.Pd.',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/homepagekurikulum');
        $this->assertAuthenticated('kurikulums');
    }

    public function test_kurikulum_dashboard_accessible(): void
    {
        $this->loginKurikulum();
        $this->get('/kurikulumpage')->assertStatus(200);
    }

    public function test_kurikulum_can_view_walas(): void
    {
        $this->loginKurikulum();
        $this->get('/kurikulumwalas')->assertStatus(200);
    }

    public function test_kurikulum_can_view_rombel(): void
    {
        $this->loginKurikulum();
        $this->get('/rombelpage')->assertStatus(200);
    }

    public function test_kurikulum_can_view_adm_walas(): void
    {
        $this->loginKurikulum();
        $this->get('/admwalasviewkurikulum')->assertStatus(200);
    }

    public function test_kurikulum_logout(): void
    {
        $this->loginKurikulum();
        $this->assertAuthenticated('kurikulums');

        $this->post('/homepagekurikulum/logout')->assertRedirect('/');
        $this->assertGuest('kurikulums');
    }

    private function loginKurikulum(): void
    {
        $this->post('/loginkurikulum/store', [
            'nama'     => 'Sri Wahyuni, M.Pd.',
            'password' => $this->password(),
        ]);
    }
}
