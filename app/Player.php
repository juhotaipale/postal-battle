<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function getTurnAttribute()
    {
        return ($this->game && $this->game->turn_player_id === $this->id);
    }

    public function getSkipTurnAttribute()
    {
        return ($this->game && $this->turn == $this->id && $this->game->previous_player_id === $this->id);
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class)
            ->where('game_id', '=', $this->game_id);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}
