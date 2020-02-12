<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Package extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'address', 'code', 'type',
    ];

    public function getJjfiAttribute(): string
    {
        return 'JJFI '.substr_replace(sprintf('%016d', $this->id), ' ', 6, 0);
    }

    public function card(): MorphOne
    {
        return $this->morphOne(Card::class, 'cardable');
    }
}
