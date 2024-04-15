<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'smsgroup_id',
        'sms_campaign_id',
        
    ];

    public function smsgroup()
    {
        return $this->belongsTo(SmsGroup::class, 'smsgroup_id');
    }

   
    public function smscampaign()
    {
        return $this->belongsTo(SmsCampaign::class, 'sms_campaign_id');
    }
}
