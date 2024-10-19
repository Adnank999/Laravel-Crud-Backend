<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientBillingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            
            'bill_to' => $this->bill_to,
            'tax_id' => $this->tax_id,
            'billing_address' => $this->billing_address,
            'billing_phone' => $this->billing_phone,
            'billing_email' => $this->billing_email,

           
        ];
    }
}
