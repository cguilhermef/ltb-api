<?php

namespace App\Http\Resources;

use App\Role;
use App\Team;
use Illuminate\Http\Resources\Json\JsonResource;

class VacancyResource extends JsonResource
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
            'team_id' => Team::find($this->team_id),
            'role_id' => Role::find($this->role_id)
        ];
    }
}
