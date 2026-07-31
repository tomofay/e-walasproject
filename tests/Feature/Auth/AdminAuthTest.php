<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthTest extends TestCase
{
    public function test_admin_can_view_login_page(): void
    {
        $this->get('/loginadmin')->assertStatus(200);
    }

    public function test_admin_can_login(): void
    {
        $response = $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);

        $response->assertRedirect('/adminpage');
        $this->assertAuthenticated('admins');
    }

    public function test_admin_cannot_login_with_wrong_password(): void
    {
        $response = $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => 'wrongpassword',
        ]);

        $response->assertRedirect('/loginadmin');
        $this->assertGuest('admins');
    }

    public function test_admin_dashboard_is_protected(): void
    {
        $this->get('/adminpage')->assertRedirect('/loginadmin');
    }

    public function test_admin_dashboard_accessible_when_logged_in(): void
    {
        $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);

        $this->get('/adminpage')->assertStatus(200);
    }

    public function test_admin_can_view_warga_sekolah(): void
    {
        $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);

        $this->get('/wargasekolah')->assertStatus(200);
        $this->get('/walas')->assertStatus(200);
        $this->get('/guru')->assertStatus(200);
        $this->get('/kakom')->assertStatus(200);
        $this->get('/kurikulum')->assertStatus(200);
        $this->get('/kepalasekolah')->assertStatus(200);
    }

    public function test_admin_can_view_rombel_and_mapel(): void
    {
        $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);

        $this->get('/rombel')->assertStatus(200);
        $this->get('/datamapel')->assertStatus(200);
    }

    public function test_admin_can_view_detail_kelas(): void
    {
        $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);

        $this->get('/detailkelas')->assertStatus(200);
    }

    public function test_admin_logout(): void
    {
        $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);

        $this->assertAuthenticated('admins');

        $this->post('/homepageadmin/logout')->assertRedirect('/');
        $this->assertGuest('admins');
    }
}
