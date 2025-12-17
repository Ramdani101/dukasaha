<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    // Trait ini wajib! Agar database di-reset bersih setiap kali test jalan
    use RefreshDatabase;

    /**
     * Test 1: Halaman Login bisa dibuka
     */
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');
        $response->assertStatus(200); // 200 artinya OK
    }

    /**
     * Test 2: User bisa Register
     */
    public function test_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'testerganteng', 
            'email' => 'test@example.com',
            'password' => 'Password@123',
            'password_confirmation' => 'Password@123',
            'g-recaptcha-response' => 'token-dummy',
        ]);
        
        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated();
        $response->assertRedirect('/home');
    }

    /**
     * Test 3: User bisa Login dengan data yang benar
     */
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('Password@123'),
        ]);

        // Cek LoginController kamu: Apakah dia pakai 'email' atau 'username'?
        // Default Laravel pakai 'email'.
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'Password@123',
            'g-recaptcha-response' => 'token-dummy',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated();
        $response->assertRedirect('/home');
    }

    /**
     * Test 4: User TIDAK bisa login kalau password salah
     */
    public function test_users_cannot_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password-benar'),
        ]);

        $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password-salah',
        ]);

        $this->assertGuest(); // Pastikan user statusnya masih tamu (belum login)
    }

    /**
     * Test 5: User bisa Logout
     */
    public function test_users_can_logout()
    {
        // Tambahkan /** @var ... */ untuk memberi tahu VS Code tipe datanya
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        // Sekarang errornya harusnya hilang
        $this->actingAs($user); 

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    
}
