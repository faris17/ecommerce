<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';

    protected $fillable = [
        'kode',
        'namabank'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'bank_has_users');
    }
}
