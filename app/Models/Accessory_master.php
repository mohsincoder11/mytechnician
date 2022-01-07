<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accessory_master extends Model
{
    use HasFactory;
protected $fillable=[
    'appliance_id',
    'accessory_name'
];
}
