<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appliance_master extends Model
{
    use HasFactory;
    protected $fillable=['appliance_name'];
}
