<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected string $baseUrl = 'http://localhost';

    public function createApplication()
    {
        // Pastikan test selalu berjalan di SQLite in-memory, terlepas dari
        // konfigurasi .env lokal (mis. yang menunjuk ke MariaDB/Docker).
        putenv('APP_ENV=testing');
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        putenv('SESSION_DRIVER=array');
        putenv('CACHE_STORE=array');
        putenv('QUEUE_CONNECTION=sync');
        $_ENV['APP_ENV'] = 'testing';
        $_ENV['DB_CONNECTION'] = 'sqlite';
        $_ENV['DB_DATABASE'] = ':memory:';
        $_ENV['SESSION_DRIVER'] = 'array';
        $_ENV['CACHE_STORE'] = 'array';
        $_ENV['QUEUE_CONNECTION'] = 'sync';
        $_SERVER['APP_ENV'] = 'testing';
        $_SERVER['DB_CONNECTION'] = 'sqlite';
        $_SERVER['DB_DATABASE'] = ':memory:';
        $_SERVER['SESSION_DRIVER'] = 'array';
        $_SERVER['CACHE_STORE'] = 'array';
        $_SERVER['QUEUE_CONNECTION'] = 'sync';

        return parent::createApplication();
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Seed database
        $this->seed();
    }

    /** Get password hash as stored in DB */
    protected function password(): string
    {
        return '12345678';
    }
}
