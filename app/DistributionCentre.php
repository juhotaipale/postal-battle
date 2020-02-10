<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Jamesh\Uuid\HasUuid;

class DistributionCentre extends Model
{
    use HasUuid;

    protected $fillable = [
        'code', 'name',
    ];

    public static function listAll()
    {
        return [
            '00000' => 'Helsinki',
            '33000' => 'Tampere',
            '40000' => 'Jyväskylä',
            '53000' => 'Lappeenranta',
            '65000' => 'Vaasa',
            '70000' => 'Kuopio',
            '90000' => 'Oulu',
            '96000' => 'Rovaniemi',
        ];
    }

    public function card(): MorphOne
    {
        return $this->morphOne(Card::class, 'cardable');
    }
}
