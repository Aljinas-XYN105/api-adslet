<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SmsCampaign extends JsonResource
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
            //'smsgroup_id' => $this->smsgroup_id,
            'smsgroup_id' => $this->smsgroup->name ?? null, 
            'description' => $this->description, 
            'message' => $this->message, 
            'phone_number'=>$this->phone_number, 
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,                          
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];

    }
}
