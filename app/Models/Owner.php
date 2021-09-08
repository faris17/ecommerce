<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners';

    protected $fillable = [
        'namausaha',
        'nohpusaha',
        'deskripsiowner',
        'coverimage',
        'status',
        'user_id'
    ];

    //relation to table payowner
    public function typeowner()
    {
        return $this->belongsToMany(Typeowner::class, 'pay_owners');
    }

    //relation to table payowner
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
