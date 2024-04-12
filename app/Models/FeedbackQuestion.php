<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackQuestion extends Model
{
    use HasFactory;
    protected $fillable = [
        'question',
        'sort_order',
        'answer_text_box',    
    ];
}
