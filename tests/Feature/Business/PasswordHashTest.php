<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;

class PasswordHashTest extends TestCase
{
    public function test_semua_password_user_di_hash(): void
    {
        // Semua auth model harus punya password hashed
        $this->assertTrue(Hash::check($this->password(), \App\Models\Admin::first()->password));
        $this->assertTrue(Hash::check($this->password(), \App\Models\Walas::first()->password));
        $this->assertTrue(Hash::check($this->password(), \App\Models\Kakom::first()->password));
        $this->assertTrue(Hash::check($this->password(), \App\Models\Kepsek::first()->password));
        $this->assertTrue(Hash::check($this->password(), \App\Models\Kurikulum::first()->password));
        $this->assertTrue(Hash::check($this->password(), Siswa::first()->password));
    }

    public function test_password_tidak_valid_dengan_hash_wrong(): void
    {
        $this->assertFalse(Hash::check('wrongpassword', \App\Models\Admin::first()->password));
    }

    public function test_model_auth_extends_authenticatable(): void
    {
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, \App\Models\Admin::first());
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, \App\Models\Walas::first());
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, \App\Models\Kakom::first());
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, \App\Models\Kepsek::first());
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, \App\Models\Kurikulum::first());
        $this->assertInstanceOf(\Illuminate\Foundation\Auth\User::class, Siswa::first());
    }

    public function test_password_hidden_di_json(): void
    {
        $admin = \App\Models\Admin::first()->toArray();
        $this->assertArrayNotHasKey('password', $admin);
    }

    public function test_welcome_page_returns_200(): void
    {
        $this->get('/')->assertStatus(200);
    }
}
