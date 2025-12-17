<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Confession;
use Carbon\Carbon;

class DeleteExpiredConfessions extends Command
{
    /**
     * Nama command yang nanti dipanggil oleh Scheduler.
     * Kita namakan: confessions:cleanup
     */
    protected $signature = 'confessions:cleanup';

    /**
     * Deskripsi command (untuk dokumentasi).
     */
    protected $description = 'Hapus pesan confession yang sudah lebih dari 24 jam';

    /**
     * Eksekusi logic penghapusan disini.
     */
    public function handle()
    {
        // 1. Hitung waktu batas (Sekarang dikurangi 24 jam)
        $limit = Carbon::now()->subHours(24);

        // 2. Hapus data yang created_at nya lebih kecil dari batas waktu
        $deletedCount = Confession::where('created_at', '<', $limit)->delete();

        // 3. Beri info di terminal (opsional, biar tau command jalan)
        $this->info("Berhasil menghapus {$deletedCount} pesan lama.");
    }
}