<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resell_product_request extends Model
{
    use HasFactory;
    protected $fillable = [
        'resell_product_id',
        'order_id',
        'user_id',
        'status',
    ];
}
