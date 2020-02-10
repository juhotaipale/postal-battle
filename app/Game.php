<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Jamesh\Uuid\HasUuid;

class Game extends Model
{
    use HasUuid;

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
