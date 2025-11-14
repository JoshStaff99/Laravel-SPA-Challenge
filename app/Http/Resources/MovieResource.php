<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
            'title' => $this->title,
            'director' => $this->director,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'tags' => $this->tags,
            'duration' => $this->duration,
        ];
    }
}