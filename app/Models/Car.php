<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'platnomor',
        'harga',
        'jenismobil',
        'keterangan',
        'gambarmobil',
        'owner_id'
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id');
    }
}
