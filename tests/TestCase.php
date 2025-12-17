<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Tambahkan fungsi ini agar middleware CSRF tidak mengganggu testing
    protected function setUp(): void
    {
        parent::setUp();
        
        // Mematikan verifikasi CSRF untuk semua test
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    }
}