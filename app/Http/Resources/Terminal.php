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
            'name' => $this->name,
            'feedback_group_id' => $this->feedback_group_id,
            'background_image'=>$this->background_image, 
            'terminal_logo' => $this->terminal_logo,
            'success_message' => $this->success_message,
            'phone_number_required'=>$this->phone_number_required,   
            'feedback_group_id' => $this->feedback_group_id,
            'email_required'=>$this->email_required, 
            'sms_sender_id' => $this->sms_sender_id,
            'notification_settings' => $this->notification_settings,
            'customer_notification'=>$this->customer_notification,                         
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];
       
        
    }
}
