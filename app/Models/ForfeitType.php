<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForfeitType extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipe',
        'biaya'
    ];

    public function forfeits(){
        return $this->hasMany(Forfeit::class);
    }
}
