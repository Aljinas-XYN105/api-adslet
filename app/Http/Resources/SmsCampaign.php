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

        $statuses = [
            0 => 'Not Started',
            1 => 'Running',
            2 => 'Paused',
            3 => 'Cancelled',
            4 => 'Finished'
        ];
        $status = isset($statuses[$this->status]) ? $statuses[$this->status] : 'Unknown';
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description, 
            'message' => $this->message, 
            'type' => $this->type,
            'smsgroup_id' => $this->smsgroup->name ?? null,
            'contact_no' => $this->contact_no,            
            'start_date' => $this->start_date,          
            'start_time' => $this->start_time, 
            'status' => $status, 
            'queue_status' => $this->queue_status,                     
            'created_at' => $this->created_at->format('m/d/Y'),
            'updated_at' => $this->updated_at->format('m/d/Y'),
        ];

        

    }
}
