<?php

namespace App\Http\Resources\Teacher;

use Illuminate\Http\Resources\Json\JsonResource;

class ListTeacherResource extends JsonResource
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
            'nig' => $this->nig,
            'full_name' => $this->first_name . " " . $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'address' => $this->address,
            'blood_type' => $this->blood_type,
            'region' => $this->region,
        ];
    }
}
