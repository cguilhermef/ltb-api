<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SummonerResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'profile_icon_id' => $this->profile_icon_id,
            'name' => $this->name,
            'level' => $this->level,
            'tier' => TierResource::collection($this->tier)
        ];
    }
}
