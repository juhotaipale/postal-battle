<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Card extends Model
{
    public $timestamps = false;

    public function cardable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): HasOne
    {
        return $this->hasOne(self::class, 'parent_id');
    }
}
