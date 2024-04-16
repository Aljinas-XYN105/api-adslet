<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'api_key',
        'api_password',
        'address1',
        'address2',
        'email',
        'phone_number',
        'wallet',
        'sms_amount'
    ];


    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    static public function getSingle($id)
    {
        return Tenant::find($id);
    }

    static public function getTenant()
    {
        return Tenant::select('tenants.*')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function branch()
{
    return $this->belongsTo(Branch::class);
}
}
