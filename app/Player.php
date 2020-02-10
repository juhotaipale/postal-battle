<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Jamesh\Uuid\HasUuid;

class Player extends Authenticatable
{
    use HasUuid;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'remember_token',
    ];
}
