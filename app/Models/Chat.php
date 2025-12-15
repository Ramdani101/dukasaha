<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'confession_id',
        'sender_type', // 'user' atau 'guest'
        'message',
        'is_read'
    ];

    // Relasi: Chat ini berada dalam satu thread Confession
    public function confession()
    {
        return $this->belongsTo(Confession::class);
    }
}