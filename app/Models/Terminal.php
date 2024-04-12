<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'background_image',
        'terminal_logo',
        'success_message',
        'feedback_group_id',
        'phone_number_required',
        'email_required',
        'sms_sender_id',
        'notification_settings',
        'customer_notification',
    
    ];

    public function feedbackgroup()
    {
        return $this->belongsTo(FeedbackGroup::class);
    }
}
