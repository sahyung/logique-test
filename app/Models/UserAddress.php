<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UuidsTrait;

class UserAddress extends Model
{
    use SoftDeletes, UuidsTrait;
    
    protected $fillable = [
        'address'
    ];

    protected $casts = [
        'id' => 'string',
        'expiry' => 'datetime',
    ];
    
    public $incrementing = false;
}
