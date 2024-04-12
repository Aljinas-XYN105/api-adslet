<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name',
        'assign_questions',
        'answer_type',
        'expected_answers',
        'answer_labels'
    ];
}
