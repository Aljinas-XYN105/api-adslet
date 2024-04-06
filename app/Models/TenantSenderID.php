<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSenderID extends Model
{
    use HasFactory;
    protected $table = 'tenant_sender_i_d_s';
    protected $fillable = ['tenant_id', 'sender_id'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
