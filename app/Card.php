<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Jamesh\Uuid\HasUuid;

class Card extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'parent_id',
    ];

    public function getOnTableAttribute(): bool
    {
        return $this->id === '423be831-7c68-4a9e-9542-c5feea7810f4' || ($this->game->started_at && !$this->player);
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
