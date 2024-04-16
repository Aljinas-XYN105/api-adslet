<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'branch_id', 
        'group_name',
        'question_id',
        'answer_type',
        'no_expected_answers',
        'answer_labels'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function feedebackquestion()
    {
        return $this->belongsTo(FeedbackQuestion::class, 'question_id');
    }
}
