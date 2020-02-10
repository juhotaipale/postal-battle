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

    public function getJjfiAttribute($value)
    {
        return 'JJFI '.substr_replace(sprintf('%16d', $value), ' ', 5, 0);
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
}
