<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'courses' => CourseResource::collection($this->whenLoaded('courses')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => $this->age,
            'phone_house' => $this->phone_house,
            'phone_mobile' => $this->phone_mobile,
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
