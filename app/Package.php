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
        'address', 'code',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->jjfi = $model->count() + 1;
        });
    }

    public function card(): MorphOne
    {
        return $this->morphOne(Card::class, 'cardable');
    }
}
