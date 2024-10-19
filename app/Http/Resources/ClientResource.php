<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => "{$this->first_name} {$this->last_name}", // Full name
            'email' => $this->email,
            'phone' => $this->phone,
            'country_code' => $this->country_code, // Country code for phone
            'company' => $this->company,
            'position' => $this->position,
            'profile_pic' => $this->profile_pic ? url('uploads/clientPicture/' . $this->profile_pic) : null,

            // Demographic Information
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'timezone' => $this->timezone,
            'language' => $this->language,

            // Billing Information
            'bill_to' => $this->bill_to,
            'tax_id' => $this->tax_id,
            'billing_address' => $this->billing_address,
            'billing_phone' => $this->billing_phone,
            'billing_email' => $this->billing_email,

            // Details and Reference
            'details' => $this->details,
            'reference' => $this->reference,

            // Shared Files
            'shared_files' => $this->shared_files,

            // Settings
            'can_access_portal' => $this->can_access_portal,
            'last_update' => $this->updated_at->format('Y-m-d H:i:s'), // Format last updated date
        ];
    }
}
