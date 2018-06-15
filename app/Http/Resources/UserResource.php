<?php

namespace App\Http\Resources;

use App\Summoner;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'email' => $this->email,
            'nickname' => $this->nickname,
            'region_id' => $this->region_id,
            'password' => $this->password,
            'summoner' => Summoner::find($this->summoner_id)
        ];
    }
}
