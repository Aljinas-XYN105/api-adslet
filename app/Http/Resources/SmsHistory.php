<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmsHistory extends JsonResource
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
            'tenantsms_id' => $this->tenantsms_id,
            'tenant_id' => $this->tenant->name,
            //'tenant_id' => $this->tenant_id,
            'msg_length' => $this->msg_length,
            'msg_count' => $this->msg_count, 
            'msg_price' => $this->msg_price,         
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
