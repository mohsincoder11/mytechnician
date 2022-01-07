<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usermanage extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'address',
        'mobile',
        'email',
        'pincode',
        'password',
        'image',
        'status'
    ];
}
