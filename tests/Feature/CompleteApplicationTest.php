<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * End-to-end regression checks for the seeded application.
 *
 * This suite intentionally checks the public login flows, every registered
 * GET endpoint, the main role dashboards, and representative admin writes.
 * A failure includes the route and response status so runtime view errors are
 * easy to locate.
 */
class CompleteApplicationTest extends TestCase
{
    public function test_seeded_database_contains_required_relationships(): void
    {
        foreach ([
            'admins',
            'walas',
            'kakoms',
            'kurikulums',
            'kepseks',
            'gurus',
            'mapels',
            'rombels',
            'siswas',
            'biodata_siswas',
            'jadwal_kbms',
            'presensis',
            'keluar_rombels',
        ] as $table) {
            $this->assertGreaterThan(
                0,
                DB::table($table)->count(),
                "Seeder tidak mengisi tabel {$table}."
            );
        }

        $this->assertSame(
            DB::table('siswas')->count(),
            DB::table('siswas')->whereNotNull('rombels_id')->count(),
            'Setiap siswa dummy harus memiliki rombel.'
        );
        $this->assertGreaterThan(
            0,
            DB::table('biodata_siswas')->whereNotNull('siswas_id')->count(),
            'Seeder harus membuat biodata siswa.'
        );
    }

    public function test_all_roles_can_login_and_open_their_dashboard(): void
    {
        $roles = [
            [
                'endpoint' => '/loginadmin',
                'name' => 'admin',
                'guard' => 'admins',
                'redirect' => '/adminpage',
                'dashboard' => '/adminpage',
            ],
            [
                'endpoint' => '/logingtk',
                'name' => 'Budi Santoso, S.Pd.',
                'guard' => 'walas',
                'redirect' => '/walaspage',
                'dashboard' => '/walaspage',
            ],
            [
                'endpoint' => '/loginkaprog',
                'name' => 'Drs. Rahmat Hidayat',
                'guard' => 'kakoms',
                'redirect' => '/homepagekaprog',
                'dashboard' => '/homepagekaprog',
            ],
            [
                'endpoint' => '/loginkepsek',
                'name' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                'guard' => 'kepseks',
                'redirect' => '/kepsekpage',
                'dashboard' => '/kepsekpage',
            ],
            [
                'endpoint' => '/loginkurikulum',
                'name' => 'Sri Wahyuni, M.Pd.',
                'guard' => 'kurikulums',
                'redirect' => '/kurikulumpage',
                'dashboard' => '/kurikulumpage',
            ],
            [
                'endpoint' => '/loginsiswa',
                'name' => 'Andi Pratama',
                'guard' => 'siswas',
                'redirect' => '/siswapage',
                'dashboard' => '/siswapage',
            ],
        ];

        foreach ($roles as $role) {
            $this->get($role['endpoint'])->assertOk();

            $response = $this->post($role['endpoint'], [
                'nama' => $role['name'],
                'password' => '12345678',
            ]);

            $response->assertRedirect($role['redirect']);
            $this->assertAuthenticated($role['guard']);
            $this->get($role['dashboard'])->assertSuccessful();

            Auth::guard($role['guard'])->logout();
            $this->flushSession();
        }
    }

    public function test_admin_can_read_and_write_core_master_data(): void
    {
        $this->post('/loginadmin', [
            'nama' => 'admin',
            'password' => '12345678',
        ])->assertRedirect('/adminpage');

        foreach ([
            '/wargasekolah',
            '/walas',
            '/guru',
            '/kakom',
            '/kurikulum',
            '/kepalasekolah',
            '/rombel',
            '/datamapel',
            '/detailkelas',
            '/keluarrombeldata',
        ] as $uri) {
            $this->get($uri)->assertSuccessful();
        }

        $this->post('/mapel/tambah/store', [
            'nama_mapel' => 'Test Mata Pelajaran',
        ])->assertRedirect();
        $this->assertDatabaseHas('mapels', ['nama_mapel' => 'Test Mata Pelajaran']);

        $walasId = DB::table('walas')->value('id');
        $this->post('/rombel/store', [
            'tingkat' => 'X',
            'kompetensi' => 'SIJA',
            'nama_kelas' => 'X SIJA TEST',
            'walas_id' => $walasId,
        ])->assertRedirect();
        $this->assertDatabaseHas('rombels', ['nama_kelas' => 'X SIJA TEST']);
    }

    public function test_every_registered_get_route_has_no_server_error(): void
    {
        $this->post('/loginadmin', [
            'nama' => 'admin',
            'password' => '12345678',
        ]);

        $failures = [];
        foreach (Route::getRoutes() as $route) {
            if (! in_array('GET', $route->methods(), true)
                && ! in_array('HEAD', $route->methods(), true)) {
                continue;
            }

            $middleware = implode('|', $route->gatherMiddleware());
            if (str_contains($middleware, 'WalasMiddleware')) {
                $this->loginWalasForRouteScan();
            } elseif (str_contains($middleware, 'KakomMiddleware')) {
                $this->post('/loginkaprog', [
                    'nama' => 'Drs. Rahmat Hidayat',
                    'password' => '12345678',
                ]);
            } elseif (str_contains($middleware, 'KepsekMiddleware')) {
                $this->post('/loginkepsek', [
                    'nama' => 'Drs. H. Ahmad Fauzi, M.Pd.',
                    'password' => '12345678',
                ]);
            } elseif (str_contains($middleware, 'KurikulumMiddleware')) {
                $this->post('/loginkurikulum', [
                    'nama' => 'Sri Wahyuni, M.Pd.',
                    'password' => '12345678',
                ]);
            } elseif (str_contains($middleware, 'SiswaMiddleware')) {
                $this->post('/loginsiswa', [
                    'nama' => 'Andi Pratama',
                    'password' => '12345678',
                ]);
            } elseif (str_contains($middleware, 'AdminMiddleware') || str_contains($middleware, '|admin')) {
                $this->post('/loginadmin', [
                    'nama' => 'admin',
                    'password' => '12345678',
                ]);
            }

            $uri = preg_replace('/\{[^}]+\}/', '1', $route->uri());
            $response = $this->get('/'.ltrim($uri, '/'));
            if ($response->getStatusCode() >= 500) {
                $body = trim(preg_replace('/\s+/', ' ', (string) $response->getContent()));
                $failures[] = sprintf(
                    '%s [%d] %s',
                    $route->uri(),
                    $response->getStatusCode(),
                    substr($body, 0, 300)
                );
            }
        }

        $this->assertSame([], $failures, "GET route errors:\n".implode("\n", $failures));
    }

    private function loginWalasForRouteScan(): void
    {
        $this->post('/logingtk', [
            'nama' => 'Budi Santoso, S.Pd.',
            'password' => '12345678',
        ]);
    }
}
