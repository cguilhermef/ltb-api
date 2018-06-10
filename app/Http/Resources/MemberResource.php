<?php

namespace App\Http\Resources;

use App\Role;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
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
            'team_id' => $this->team_id,
            'role_id' => $this->role_id,
            'user_id' => $this->user_id
        ];
    }
}
