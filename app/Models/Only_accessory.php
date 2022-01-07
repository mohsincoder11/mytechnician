<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Only_accessory extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'order_id',
        'appliance_id',
        'accessory_id'
    ];
}
