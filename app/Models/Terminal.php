<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;
    protected $fillable = [
        'tenant_id',
        'branch_id',
        'name',
        'terminal_code',
        'background_image',
        'terminal_logo',
        'success_message',
        'feedback_group_id',
        'sms_sender_id',
       
    
    ];

    public function feedbackgroup()
    {
        return $this->belongsTo(FeedbackGroup::class, 'feedback_group_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
