<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lend extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_buku',
        'id_anggota',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_dikembalikan',
        'status_peminjaman'
    ];

    public function books()
    {
        return $this->belongsTo(Book::class, 'id_buku');
    }

    public function members()
    {
        return $this->belongsTo(Member::class, 'id_anggota');
    }
}
