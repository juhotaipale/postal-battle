<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Jamesh\Uuid\HasUuid;

class Card extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'parent_id',
    ];

    public function getOnTableAttribute(): bool
    {
        return $this->game->started_at && !$this->player;
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function cardable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): HasOne
    {
        return $this->hasOne(self::class, 'parent_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
