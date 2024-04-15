<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Terminal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'tenant_id' => $this->tenant->name ?? null,
            'branch_id' => $this->branch->name ?? null, 
            'name' => $this->name ,
            'terminal_code' => $this->terminal_code,
            'feedback_group_id' => $this->feedbackgroup->group_name ?? null,
            'background_image'=>$this->background_image, 
            'terminal_logo' => $this->terminal_logo,
            'success_message' => $this->success_message,             
            'sms_sender_id' => $this->sms_sender_id,                    
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
       
        
    }
}
