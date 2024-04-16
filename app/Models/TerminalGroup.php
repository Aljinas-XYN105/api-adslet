<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerminalGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'feedback_group_id',
        'feedback_question_id',    
    ];

    public function feedbackgroup()
    {
        return $this->belongsTo(FeedbackGroup::class);
    }

    
    public function feedbackquestion()
    {
        return $this->belongsTo(FeedbackQuestion::class);
    }
}
