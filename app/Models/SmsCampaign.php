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
        // 'smsgroup_id',
        'contact_no',
        'start_date',
        'start_time',
        'status',
        'queue_status',
       ];
    
       protected $casts = [
        'type' => 'boolean',
        'status' => 'integer',
        'contact_no' => 'array',
    ];

    public function campaigncontact()
{
    return $this->hasMany(SmsCampignContact::class);
}
   
    // public static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($smsCampaign) {
    //         $smsCampaign->campaignHistory()->delete();
    //     });
    // }

//     public function campaignhistory()
// {
//     return $this->hasMany(CampaignHistory::class, 'sms_campaign_id');
// }
            public function smsCampignContacts()
            {
                return $this->hasMany(SmsCampignContact::class);
            }

            public function campaignHistory()
            {
                return $this->hasMany(CampaignHistory::class);
            }

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
