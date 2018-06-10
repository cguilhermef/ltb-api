<?php

namespace App\Http\Resources;

use App\Member;
use App\Summoner;
use App\Team;
use App\User;
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
            'members' => MemberResource::collection($this->members),
            'modes' => ModeResource::collection($this->modes),
            'name' => $this->name,
            'tier_min' => $this->tier_min,
            'user' => User::find($this->user_id),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at
        ];
    }


}
