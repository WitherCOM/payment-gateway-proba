<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $phones = [];
        foreach($this->phones as $phone)
        {
            $phones[] = $phone->phoneNumber;
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'dateOfBirth' => $this->dateOfBirth,
            'isActive' => $this->isActive,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'phoneNumbers' => $phones,
        ];
    }
}
