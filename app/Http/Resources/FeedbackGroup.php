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
        'group_name' => $this->group_name,
        'assign_questions' => $this->assign_questions,
        'answer_type'=>$this->answer_type, 
        'expected_answers' => $this->expected_answers,
        'answer_labels'=>$this->answer_labels,                           
        'created_at' => $this->created_at->format('m/d/Y'),
        'updated_at' => $this->updated_at->format('m/d/Y'),
    ];
    }
}
