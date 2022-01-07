<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'city',
        'mobile',
    ];
}
