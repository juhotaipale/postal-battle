<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
