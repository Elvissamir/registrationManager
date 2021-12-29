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
            'first' => $this->whenPivotLoaded('student_subject', function () { return $this->pivot->first; }),
            'second' => $this->whenPivotLoaded('student_subject', function () { return $this->pivot->second; }),
            'third' => $this->whenPivotLoaded('student_subject', function () { return $this->pivot->third; }),
            'fourth' => $this->whenPivotLoaded('student_subject', function () { return $this->pivot->fourth; }),
            'title' => $this->title,
            'credits' => $this->credits,
            'created_at' => $this->created_at,
        ];
    }
}
