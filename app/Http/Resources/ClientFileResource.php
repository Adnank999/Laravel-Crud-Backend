<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientFileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // 'file_path' => $this->shared_files ? asset('storage/' . $this->shared_files) : null,

            'shared_files' => $this->shared_files ? array_map(function ($file) {
                return asset('storage/' . $file); 
            }, $this->shared_files) : [],
        ];
    }
}
