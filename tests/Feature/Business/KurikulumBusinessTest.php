<?php

namespace Tests\Feature\Business;

use Tests\TestCase;

class KurikulumBusinessTest extends TestCase
{
    public function test_kurikulum_can_view_walas_data(): void
    {
        $this->loginKurikulum();

        $this->get('/kurikulumwalas')->assertStatus(200);
        $this->get('/rombelpage')->assertStatus(200);
        $this->get('/admwalasviewkurikulum')->assertStatus(200);
    }

    /** Kurikulum view administrasi walas */
    public function test_kurikulum_can_view_all_walas_administration(): void
    {
        $this->loginKurikulum();

        $views = [
            'agendawalasviewkurikulum',
            'identiaskelasviewkurikulum',
            'lembarpengesahanviewkurikulum',
            'jadwalkbmviewkurikulum',
            'presensisviewkurikulum',
            'piketkelasviewkurikulum',
            'serahterimaraporviewkurikulum',
            'catatankasusviewkurikulum',
            'homevisitviewkurikulum',
            'bukutamuviewkurikulum',
        ];

        foreach ($views as $route) {
            $this->get('/' . $route)->assertStatus(200);
        }
    }

    private function loginKurikulum(): void
    {
        $this->post('/loginkurikulum/store', [
            'nama'     => 'Sri Wahyuni, M.Pd.',
            'password' => $this->password(),
        ]);
    }
}
