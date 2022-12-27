<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori',
        'judul',
        'deskripsi',
        'author',
        'cover_image',
        'qty'
    ];

    public function bookCategory(){
        return $this->belongsTo(BookCategory::class);
    }

    public function lends(){
        return $this->hasMany(Lend::class);
    }
}
