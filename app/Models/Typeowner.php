<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeowner extends Model
{
    use HasFactory;

    protected $table = "typeowners";

    protected $fillable = [
        'nametypeowner',
        'harga',
        'perpanjang',
        'keterangan'
    ];

    public function owner()
    {
        return $this->belongsToMany(Owner::class, 'payowners');
    }
}
