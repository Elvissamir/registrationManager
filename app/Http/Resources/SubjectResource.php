<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
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
            'teachers' => TeacherResource::collection($this->whenLoaded('teachers')),
            'title' => $this->title,
            'credits' => $this->credits,
            'created_at' => $this->created_at,
        ];
    }
}
