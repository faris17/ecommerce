<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankHasUser extends Model
{
    use HasFactory;

    protected $table = 'bank_has_users';

    protected $fillable = ['bank_id', 'user_id', 'nomorrekening'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function bank()
    {
        return $this->hasOne(Bank::class, 'id', 'bank_id');
    }
}
