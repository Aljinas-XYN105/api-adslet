<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'msg_length',
        'msg_count',
        'msg_price',
        'phonenumber',
        'textmessage',
        'response',
        'msg_type',
        'status',
        'sender_id',
        'tenant_sms_price'

    ];
    protected $casts = [
        'response' => 'json',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
