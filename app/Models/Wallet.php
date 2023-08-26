<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $table="wallets";
    protected $fillable = [
        'id',
        'name_wallet',
        'price',
        'user_id',
    ];
    protected $hidden=[];
}
