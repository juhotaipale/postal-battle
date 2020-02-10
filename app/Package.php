<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Jamesh\Uuid\HasUuid;

class Package extends Model
{
    use HasUuid;

    public $timestamps = false;

    public function card(): MorphOne
    {
        return $this->morphOne(Card::class, 'cardable');
    }
}
