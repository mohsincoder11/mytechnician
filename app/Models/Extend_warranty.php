<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extend_warranty extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'service_code',
        'brand_name',
        'appliance_id',
        'date_of_purchase',
        'status'
    ];
}
