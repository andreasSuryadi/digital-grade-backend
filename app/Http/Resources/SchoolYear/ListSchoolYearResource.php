<?php

namespace App\Http\Resources\SchoolYear;

use Illuminate\Http\Resources\Json\JsonResource;

class ListSchoolYearResource extends JsonResource
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
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'semester' => $this->semester,
        ];
    }
}
