<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forfeit extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_peminjaman',
        'id_tipe_denda',
        'lama_hari',
    ];

    public function forfeitTypes() {
        return $this->belongsTo(ForfeitType::class);
    }
}
