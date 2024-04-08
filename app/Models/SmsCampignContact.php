<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCampignContact extends Model
{
    use HasFactory;
    protected $table = 'sms_campaign_contacts';
    protected $fillable = [
        'sms_campaign_id',
        'contact_no',
       
       ];

       protected $casts = [
        'contact_no' => 'array',
    ];

    public function smscampaign()
    {
        return $this->belongsTo(SmsCampaign::class, 'sms_campaign_id');
    }
}
