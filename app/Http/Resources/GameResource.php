<?php

namespace App\Http\Resources;

use App\Player;
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
            'created_at' => $this->created_at,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'winner' => $this->winner,
            'players' => PlayerResource::collection($this->whenLoaded('players')),
            'cards' => CardResource::collection($this->whenLoaded('cards')),
        ];
    }
}
