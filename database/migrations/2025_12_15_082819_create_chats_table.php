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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            
            // Mengaitkan chat ini ke thread confession tertentu
            // Jika confession dihapus (setelah 24 jam), chat ini otomatis hilang
            $table->foreignId('confession_id')->constrained('confessions')->onDelete('cascade');
            
            // Penanda siapa yang mengirim chat ini
            // Values: 'user' (Anda) atau 'guest' (Pengirim Anon)
            $table->enum('sender_type', ['user', 'guest']);
            
            // Isi balasan chat
            $table->text('message');
            
            // Status apakah sudah dibaca lawan bicara (untuk fitur centang biru/read)
            $table->boolean('is_read')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
