<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Jamesh\Uuid\HasUuid;

class Package extends Model
{
    use HasUuid;

    public $timestamps = false;

    protected $fillable = [
        'address', 'code', 'type',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->jjfi = $model->count() + 1;
        });
    }

    public function getJjfiAttribute($value): string
    {
        return 'JJFI '.substr_replace(sprintf('%016d', $value), ' ', 6, 0);
    }

    public function card(): MorphOne
    {
        return $this->morphOne(Card::class, 'cardable');
    }
}
