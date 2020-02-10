<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
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
            'jjfi' => $this->jjfi,
            'address' => $this->address,
            'code' => $this->code,
            'type' => $this->type,
        ];
    }
}
