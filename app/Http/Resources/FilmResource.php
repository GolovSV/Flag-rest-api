<?php

namespace App\Http\Resources;

use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => Carbon::parse($this->year)->format('Y'),
            'country' => $this->country,
            'genre' => $this->genre->title,
        ];
    }
}
