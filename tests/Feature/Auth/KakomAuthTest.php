<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;

class KakomAuthTest extends TestCase
{
    public function test_kakom_can_login(): void
    {
        $response = $this->post('/loginkaprog/store', [
            'nama'     => 'Drs. Rahmat Hidayat',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/homepagekaprog');
        $this->assertAuthenticated('kakoms');
    }

    public function test_kakom_dashboard_accessible(): void
    {
        $this->loginKakom();
        $this->get('/homepagekaprog')->assertStatus(200);
    }

    public function test_kakom_can_view_walas(): void
    {
        $this->loginKakom();
        $this->get('/kakomwalas')->assertStatus(200);
    }

    public function test_kakom_can_view_rombel(): void
    {
        $this->loginKakom();
        $this->get('/kakomrombel')->assertStatus(200);
    }

    public function test_kakom_can_view_adm_walas_data(): void
    {
        $this->loginKakom();
        $this->get('/admwalasview')->assertStatus(200);
    }

    public function test_kakom_logout(): void
    {
        $this->loginKakom();
        $this->assertAuthenticated('kakoms');

        $this->post('/homepagekaprog/logout')->assertRedirect('/');
        $this->assertGuest('kakoms');
    }

    private function loginKakom(): void
    {
        $this->post('/loginkaprog/store', [
            'nama'     => 'Drs. Rahmat Hidayat',
            'password' => $this->password(),
        ]);
    }
}
