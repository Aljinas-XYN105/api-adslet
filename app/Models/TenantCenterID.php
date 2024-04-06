<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantCenterID extends Model
{
    use HasFactory;
    protected $table = 'tenant_center_i_d_s';
    protected $fillable = ['tenant_id', 'sender_id'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
