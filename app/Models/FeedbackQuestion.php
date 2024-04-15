<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'branch_id', 
        'question',
        'sort_order',
        'answer_text_box',    
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
