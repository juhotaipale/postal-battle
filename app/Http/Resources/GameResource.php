<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'players' => PlayerResource::collection($this->players),
            'cards' => CardResource::collection($this->cards),
        ];
    }
}
