<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    protected $table="details";
    protected $fillable = [
        'id',
        'details',
        'price',
        'user_id',
        'user_id_wallet',
    ];
    protected $hidden=['created_at','updated_at'];
    
}
