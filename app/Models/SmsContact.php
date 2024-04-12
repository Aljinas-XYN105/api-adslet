<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsContact extends Model
{
    use HasFactory;
    protected $table = 'sms_contacts';
    
    protected $fillable = [
        'first_name',
        'last_name',
        'smsgroup_id',
        'phone_number',
    ];

    protected $casts = [
        'phone_number' => 'array',
    ];

    public function smsgroup()
    {
        return $this->belongsTo(SmsGroup::class);
    }
}
