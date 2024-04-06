<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Tenant extends JsonResource
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
            'name' => $this->name,
            //'slug' => $this->slug,
            'email' => $this->email,
            'api_key' =>$this->api_key,
            'api_password' =>$this->api_password,
            //'no_of_terminals' => $this->no_of_terminals,
            'address1' => $this->address1,
            'address2' => $this->address2,
            'phone_number'=>$this->phone_number,
            'wallet'=>$this->wallet,  
            'sms_amount' =>$this->sms_amount,         
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
    }
}
