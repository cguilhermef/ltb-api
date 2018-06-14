<?php

namespace App\Http\Resources;

use App\Vacancy;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidadeResource extends JsonResource
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
            'vacancy_id' => $this->vacancy_id,
            'user' => User::find($this->user_id),
            'vacancy' => Vacancy::find($this->vacancy_id)
        ];
    }
}
