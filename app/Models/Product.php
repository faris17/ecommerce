<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'namaproduk',
        'hargasatuan',
        'diskon',
        'satuan',
        'stock',
        'ukuran',
        'pilihanwarna',
        'deskripsi',
        'ongkir',
        'owner_id',
        'jenispembayaran'

    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
