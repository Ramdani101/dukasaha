<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Confession;
use Carbon\Carbon;

class DeleteExpiredConfessions extends Command
{
    // nama command yang akan dijalankan di terminal
    protected $signature = 'confessions:cleanup';

    // Deskripsi singkat command
    protected $description = 'Hapus pesan confession yang sudah lebih dari 24 jam';

    // Logic penghapusan pesan confession yang sudah lebih dari 24 jam
    public function handle()
    {
        // 1. Hitung waktu batas (Sekarang dikurangi 24 jam)
        $limit = Carbon::now()->subHours(24);

        // 2. Hapus data yang created_at nya lebih kecil dari batas waktu
        $deletedCount = Confession::where('created_at', '<', $limit)->delete();
    }
}