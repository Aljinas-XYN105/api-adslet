<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'terminal_id',
        'feedback_group_id',
        'total_feedbacks', 
        'average_rating',
        'low_rank_question',
        'high_rank_question',    
    ];   

    public function terminal()
    {
        return $this->belongsTo(Terminal::class);
    }

    public function feedbackGroup()
    {
        return $this->belongsTo(FeedbackGroup::class);
    }
   
}

           