<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'id' => $this->id,
            'section' => new SectionResource($this->whenLoaded('section')),
            'degree' => new DegreeResource($this->whenLoaded('degree')),
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'students' => StudentResource::collection($this->whenLoaded('students')),
            'period' => $this->period,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),
        ];
    }
}
