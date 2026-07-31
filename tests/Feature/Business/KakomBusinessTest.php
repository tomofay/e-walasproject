<?php

namespace Tests\Feature\Business;

use Tests\TestCase;

class KakomBusinessTest extends TestCase
{
    public function test_kakom_can_view_walas_data(): void
    {
        $this->loginKakom();

        $this->get('/kakomwalas')->assertStatus(200);
        $this->get('/kakomrombel')->assertStatus(200);
        $this->get('/admwalasview')->assertStatus(200);
    }

    /** Kakom view administrasi walas */
    public function test_kakom_can_view_all_walas_administration(): void
    {
        $this->loginKakom();

        $views = [
            'agendawalasview',
            'identiaskelasview',
            'lembarpengesahanview',
            'jadwalkbmview',
            'presensisview',
            'piketkelasview',
            'serahterimaraporview',
            'catatankasusview',
            'daftarpesertadidikview',
            'homevisitview',
            'bukutamuview',
        ];

        foreach ($views as $route) {
            $this->get('/' . $route)->assertStatus(200);
        }
    }

    private function loginKakom(): void
    {
        $this->post('/loginkaprog/store', [
            'nama'     => 'Drs. Rahmat Hidayat',
            'password' => $this->password(),
        ]);
    }
}
