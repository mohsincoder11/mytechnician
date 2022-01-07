<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician_rating extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'service_id',
        'rating',
        'review',
        'rating_for'
    ];
}
