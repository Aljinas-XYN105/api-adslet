<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'sms_campaign_id',
        'user_id',
        'date',
        'contact_no',
        'message',
        'time',
        'status',
        'queue_status',
       
    ];
    protected $casts = [
        'status' => 'integer',
    ];
    public function smscampaign()
    {
        return $this->belongsTo(SmsCampaign::class, 'sms_campaign_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    const STATUS_NOT_STARTED = 0;
    const STATUS_RUNNING = 1;
    const STATUS_PAUSED = 2;
    const STATUS_CANCELLED = 3;
    const STATUS_FINISHED = 4;

}
