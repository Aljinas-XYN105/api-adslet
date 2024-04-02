<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Question extends JsonResource
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
            //'branch_id' => $this->branch_id,
            //'tenant_id' => $this->tenant_id,
            'branch_id' => $this->branch->name,
            'tenant_id' => $this->tenant->name,
            'questions'=>$this->questions,
            'answer_type'=>$this->answer_type,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at'=> $this->deleted_at,
        ];
    }
}
