<?php

namespace Tests\Feature\Business;

use Tests\TestCase;

class AdminBusinessTest extends TestCase
{
    /** Admin login → kelola walas → tampil data */
    public function test_admin_crud_walas_flow(): void
    {
        $this->loginAdmin();

        // View list
        $this->get('/walas')->assertStatus(200)->assertSee('Budi Santoso');

        // Create
        $this->post('/walas/store', [
            'nama'          => 'Test Walas',
            'jenis_kelamin' => 'Laki-laki',
            'no_wa'         => '081000000000',
            'password'      => '12345678',
            'nip'           => '199001012020011001',
        ])->assertRedirect('/walas');

        // Search
        $this->get('/walas_search?keyword=Test')->assertStatus(200)->assertSee('Test Walas');
    }

    /** Admin login → kelola guru → tampil data */
    public function test_admin_can_manage_guru(): void
    {
        $this->loginAdmin();
        $this->get('/guru')->assertStatus(200);
    }

    /** Admin login → kelola rombel → tampil data */
    public function test_admin_can_manage_rombel(): void
    {
        $this->loginAdmin();
        $this->get('/rombel')->assertStatus(200)->assertSee('X SIJA 1');
    }

    /** Admin login → detail kelas → view siswa */
    public function test_admin_can_view_detail_kelas(): void
    {
        $this->loginAdmin();
        $this->get('/detailkelas')->assertStatus(200);
    }

    /** Admin login → download template */
    public function test_admin_download_template(): void
    {
        $this->loginAdmin();
        // Semua download template seharusnya return 302 (back) jika file tidak ada
        $this->get('/guru-download-template')->assertRedirect();
    }

    private function loginAdmin(): void
    {
        $this->post('/loginadmin/store', [
            'nama'     => 'admin',
            'password' => $this->password(),
        ]);
    }
}
