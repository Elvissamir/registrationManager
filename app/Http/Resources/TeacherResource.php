<?php

namespace App\Http\Resources;

use App\Http\Resources\SubjectResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'subjects' => SubjectResource::collection($this->whenLoaded('subjects')),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'ci' => $this->ci,
            'age' => $this->age,
            'phone_house' => $this->phone_house,
            'phone_mobile' => $this->phone_mobile,
            'created_at' => $this->created_at,
        ];
    }
}
