<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientAllResource extends JsonResource
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
            'profile_pic' => $this->photo ? url('storage/' . $this->photo) : null,
            'last_update' => $this->updated_at->format('Y-m-d H:i:s'),

           
        ];
    }
}
