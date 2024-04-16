<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackGroupQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'feedback_group_id',
        'feedback_question_id'
    ];
}
