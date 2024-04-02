<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TerminalQuestion extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'question_id',
        'terminal_id',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function terminal()
    {
        return $this->belongsTo(Terminal::class);
    }
}
