<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackGroup extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);
       return [
        'id' => $this->id,
        'tenant_id' => $this->tenant->name ?? null,
        'branch_id' => $this->branch->name ?? null, 
        'group_name' => $this->group_name,
        'answer_type'=>$this->answer_type, 
        'no_expected_answers' => $this->no_expected_answers,
        'answer_labels'=>$this->answer_labels,                           
        'created_at' => $this->created_at->format('m/d/Y'),
        'updated_at' => $this->updated_at->format('m/d/Y'),
    ];
    }
}
