<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayOwner extends Model
{
    use HasFactory;

    protected $table = 'pay_owners';

    protected $fillable = [
        'transactionid',
        'owner_id',
        'typeowner_id',
        'tanggalbayar',
        'status',
        'harga',
        'notabayar',
        'payment_url'
    ];

    //relation to table owner
    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'id');
    }

    //relation to table typeowner
    public function typeowner()
    {
        return $this->belongsTo(Typeowner::class, 'typeowner_id', 'id');
    }
}
