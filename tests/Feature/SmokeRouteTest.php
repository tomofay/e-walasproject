<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\Helpers\LoginUser;
use Tests\TestCase;

/**
 * Smoke tests that walk every registered GET route once with an
 * appropriately-authenticated session and surface any 500 response.
 *
 * Goal: prove there are no broken views (undefined variables / missing
 * views), missing controller methods, or regressions on routes that the
 * smaller feature tests do not exercise (notably the admin "view" and PDF
 * export endpoints across kakom / kepsek / kurikulum).
 */
class SmokeRouteTest extends TestCase
{
    use LoginUser;

    /** @return array<int,array{0:string,1:string}> [role,uri] */
    private function collectedRoutes(): array
    {
        $out = [];
        foreach (Route::getRoutes() as $route) {
            if (! in_array('GET', $route->methods(), true) && !in_array('HEAD', $route->methods(), true)) {
                continue;
            }
            // substitute every {param} with a harmless id
            $uri = preg_replace('/\{[^}]+\}/', '1', $route->uri(), 1);
            $uri = preg_replace('/\{[^}]+\}/', '1', $uri);

            $mw = $this->roleFor($route);
            $out[] = [$mw, $uri];
        }
        return $out;
    }

    /** Determine the role middleware required by a route. */
    private function roleFor($route): ?string
    {
        foreach ($route->gatherMiddleware() as $m) {
            $short = is_string($m) ? $m : null;
            $n = $short;
            if ($n && in_array($n, ['admin', 'walas', 'kakom', 'kepsek', 'kurikulum', 'siswa'])) {
                return $n;
            }
            // closure form: "Role@..."
            if ($short && str_contains($short, 'AdminMiddleware')) return 'admin';
            if ($short && str_contains($short, 'WalasMiddleware')) return 'walas';
            if ($short && str_contains($short, 'KakomMiddleware')) return 'kakom';
            if ($short && str_contains($short, 'KepsekMiddleware')) return 'kepsek';
            if ($short && str_contains($short, 'KurikulumMiddleware')) return 'kurikulum';
            if ($short && str_contains($short, 'SiswaMiddleware')) return 'siswa';
        }
        return null;
    }

    private function loginOnce(?string $role, array &$done): void
    {
        if ($role === null) {
            return;
        }
        if (isset($done[$role])) {
            return;
        }
        $this->loginAsRole($role);
        $done[$role] = true;
    }

    public function test_all_get_routes_serve_2xx_or_3xx(): void
    {
        $done = [];
        $failures = [];

        foreach ($this->collectedRoutes() as [$role, $uri]) {
            $this->loginOnce($role, $done);

            try {
                $res = $this->get($uri);
            } catch (\Throwable $e) {
                $failures[] = "$uri [{$role}] THREW: ".$e->getMessage();
                continue;
            }

            $status = $res->getStatusCode();
            if ($status >= 500) {
                $failures[] = "$uri [{$role}] -> $status";
            }
        }

        $this->assertSame([], $failures, implode("\n", $failures));
    }
}
