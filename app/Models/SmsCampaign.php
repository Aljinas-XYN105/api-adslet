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
        'status'
       ];
    
       protected $casts = [
        'phone_number' => 'array',
       ];

       public function smsgroup()
        {
            return $this->belongsTo(SmsGroup::class);
        }
}
