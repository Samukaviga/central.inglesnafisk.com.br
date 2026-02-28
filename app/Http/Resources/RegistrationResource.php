<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                      => $this->id,
            'first_name'            => $this->first_name,
            'name'            => $this->name,
            'email'        => $this->email,
            'course_1'        => $this->course_1,
            'course_2'        => $this->course_2,
            'course_3'        => $this->course_3,
            'city'        => $this->city,

        ];
    }
}
