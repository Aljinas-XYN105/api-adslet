<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'email', 
        //'no_of_terminals',
        'location', 
        'address', 
        'phone_number'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    static public function getSingle($id)
    {
        return Branch::find($id);
      
    }

    static public function getBranch()
    {
        return Branch::select('branches.*')
        ->orderBy('id','desc')
        ->get();
    }

    static public function getTenantname()
    {
        return Tenant::select('tenants.*')
        ->orderBy('id','desc')
        ->get();
    }
}
