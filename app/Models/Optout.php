<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optout extends Model
{
    use HasFactory;

    protected $fillable = [
        'ufax',
        'uphone',
        'ip_address',
        'status',
    ];

}
