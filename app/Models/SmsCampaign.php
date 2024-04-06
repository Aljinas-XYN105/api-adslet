<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsCampaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'smsgroup_id',
        'description',
        'message',
        'phone_number',
        'start_date',
        'end_date',
       ];

       protected $casts = [
        'phone_number' => 'array',
       ];

       public function smsgroup()
        {
            return $this->belongsTo(SmsGroup::class);
        }
}
