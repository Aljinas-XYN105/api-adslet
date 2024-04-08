<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCampaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'message',
        'type',
        'start_date',
        'start_time',
        'status',
        'queue_status',
       ];
    
       protected $casts = [
        'type' => 'boolean',
        'status' => 'integer',
    ];

       public function smsgroup()
        {
            return $this->belongsTo(SmsGroup::class);
        }

        const STATUS_NOT_STARTED = 0;
        const STATUS_RUNNING = 1;
        const STATUS_PAUSED = 2;
        const STATUS_CANCELLED = 3;
        const STATUS_FINISHED = 4;
}
