<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('confessions', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User pemilik link (Penerima)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Pesan awal yang dikirim anonim (Headline pesan di Inbox)
            $table->text('message'); 
            
            // Token unik untuk Sender (Guest) agar bisa masuk kembali ke chat room ini
            // Dibuat pakai Str::random(32) atau Str::uuid()
            $table->string('guest_token', 64)->unique(); 
            
            // Opsional: IP Address sender untuk fitur Safety (blokir jika spam)
            $table->string('ip_address', 45)->nullable(); 
            
            $table->timestamps(); 
            // created_at di sini yang menjadi acuan penghapusan 24 jam
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confessions');
    }
};
