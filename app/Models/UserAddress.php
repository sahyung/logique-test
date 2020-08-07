<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidsTrait;

class UserAddress extends Model
{
    use UuidsTrait;
    
    protected $fillable = [
        'address'
    ];

    protected $casts = [
        'id' => 'string',
        'expiry' => 'datetime',
    ];
    
    public $incrementing = false;
}
