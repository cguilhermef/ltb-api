<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\Resource;
use App\Mode;

class MapResource extends Resource
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
            'name' => $this->name,
            'active' => $this->active,
            'modes' => Mode::where('map_id', $this->id)->get()
        ];
    }
}
