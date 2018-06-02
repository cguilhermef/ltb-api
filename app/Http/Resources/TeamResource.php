<?php

namespace App\Http\Resources;

use App\Team;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

//    public function listByUser() {
//        return Team::where()
//    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'abbreviation' => $this->abbreviation,
            'name' => $this->name,
            'tier_min' => $this->tier_min,
            'user_id' => $this->user_id,
            'modes' => ModeResource::collection($this->modes),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }


}
