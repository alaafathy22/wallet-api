<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $table = "wallets";
    protected $fillable = [
        'id',
        'name_wallet',
        'price',
        'user_id',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function Details_wallets()
    {
        return $this->hasMany('App\Models\Detail','user_id_wallet');
    }
}
