<?php

namespace Tests\Feature\Business;

use Tests\TestCase;

class KepsekBusinessTest extends TestCase
{
    public function test_kepsek_can_view_walas_data(): void
    {
        $this->loginKepsek();

        $this->get('/kepsekwalas')->assertStatus(200);
        $this->get('/kepsekrombel')->assertStatus(200);
        $this->get('/admwalasviewkepsek')->assertStatus(200);
    }

    /** Kepsek view administrasi walas */
    public function test_kepsek_can_view_all_walas_administration(): void
    {
        $this->loginKepsek();

        $views = [
            'agendawalasviewkepsek',
            'identiaskelasviewkepsek',
            'lembarpengesahanviewkepsek',
            'jadwalkbmviewkepsek',
            'presensisviewkepsek',
            'piketkelasviewkepsek',
            'serahterimaraporviewkepsek',
            'catatankasusviewkepsek',
            'homevisitviewkepsek',
            'bukutamuviewkepsek',
        ];

        foreach ($views as $route) {
            $this->get('/' . $route)->assertStatus(200);
        }
    }

    private function loginKepsek(): void
    {
        $this->post('/loginkepsek/store', [
            'nama'     => 'Drs. H. Ahmad Fauzi, M.Pd.',
            'password' => $this->password(),
        ]);
    }
}
