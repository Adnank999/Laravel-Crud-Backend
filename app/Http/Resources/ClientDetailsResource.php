<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => "{$this->first_name} {$this->last_name}",
            'email' => $this->email,
            'phone' => $this->phone,
            'country_code' => $this->country_code,
            'company' => $this->company,
            'position' => $this->position,
            'timezone' => $this->timezone,
            'profile_pic' => $this->profile_pic ? url($this->profile_pic) : null,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'language' => $this->language,
            'address' => $this->address,
            'email' => $this->email,
            'details'=> $this->details,
            'reference' => $this->reference,

            'last_update' => $this->updated_at->format('Y-m-d H:i:s'),

           
        ];
    }
}
