<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'smsgroup_id',       
        'phone_number',
       
       ];

       public function smsgroup()
        {
            return $this->belongsTo(SmsGroup::class);
        }
}

