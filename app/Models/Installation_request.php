<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation_request extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'service_code',
        'appliance_id',
        'brand_name',
        'date_of_purchase',
        'accessory',
        'specific_requirement',
        'status'
    ];
}
