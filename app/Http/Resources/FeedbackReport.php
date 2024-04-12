<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackReport extends JsonResource
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
        'terminal_id' => $this->terminal_id,
        'feedback_group_id' => $this->feedback_group_id,
        'total_feedbacks'=>$this->total_feedbacks, 
        'average_rating' => $this->average_rating,
        'low_rank_question' => $this->low_rank_question,
        'high_rank_question'=>$this->high_rank_question,                           
        'created_at' => $this->created_at->format('m/d/Y'),
        'updated_at' => $this->updated_at->format('m/d/Y'),
    ];
    } 
   
}
