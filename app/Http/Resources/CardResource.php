<?php

namespace App\Http\Resources;

use App\Package;
use Illuminate\Http\Resources\Json\JsonResource;

class CardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'type' => $this->cardable_type === Package::class ? 'package' : 'distributionCentre',
            'data' => $this->cardable_type === Package::class
                ? new PackageResource($this->cardable)
                : new DistributionCentreResource($this->cardable),
        ];
    }
}
