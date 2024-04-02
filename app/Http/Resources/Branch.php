<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Branch extends JsonResource
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
            //'tenant_id' => $this->tenant_id,
            'tenant_id' => $this->tenant->name,
            'name' => $this->name,
            'email' => $this->email,
            'no_of_terminals' => $this->no_of_terminals,
            'location' => $this->location,  
            'address' => $this->address,
            'phone_number'=>$this->phone_number,
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
