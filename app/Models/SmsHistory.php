<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenantsms_id',
        'tenant_id',
        'msg_length',
        'msg_count',
        'msg_price',
        'phonenumber',
        'textmessage',
        'response',
        'msg_type',
        'status',

    ];
    protected $casts = [
        'response' => 'json',
    ];

    

   
   
    
   
   
    public function tenantSmsGateway()
    {
        return $this->belongsTo(TenantSmsGateway::class, 'tenantsms_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
