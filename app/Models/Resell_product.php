<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resell_product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'appliance_id',
        'purchase_date',
        'brand_name',
        'description',
        'price',
        'warranty',
        'status',
        'images'
    ];
}
