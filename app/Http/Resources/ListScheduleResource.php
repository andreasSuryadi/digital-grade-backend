<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListScheduleResource extends JsonResource
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
            'full_name' => $this->user == null ? null : ($this->user->first_name . " " . $this->user->last_name),
            'class' => $this->class == null ? null : $this->class->name,
            'course' => $this->course == null ? null : $this->course->name,
            'day' => $this->day,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ];
    }
}
