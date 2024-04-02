<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantSmsGateway extends JsonResource
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
            'tenant_id' => $this->tenant_id,
            'api_id' => $this->api_id,
            'api_password' => $this->api_password,
            'sender_id' => $this->sender_id,
            'phonenumber' => $this->phonenumber,
            'textmessage' => $this->textmessage,
            'amount'=>$this->amount,
            'msg_type'=>$this->msg_type,       
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
