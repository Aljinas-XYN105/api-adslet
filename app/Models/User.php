<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'branch_id',
        'tenant_id',
        'name',
        'email',
        'mobile_no',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    static public function getSingle($id)
    {
        return User::find($id);
      
    }

    static public function getUser()
    {
        return User::select('users.*')
        ->orderBy('id','desc')
        ->get();
    }


    static public function getTenantname()
    {
        return Tenant::select('tenants.name')
        ->orderBy('id','desc')
        ->get();
    }
    static public function getBranchesname()
    {
        return Tenant::select('branches.name')
        ->orderBy('id','desc')
        ->get();
    }
    static public function getRolename()
    {
        return Tenant::select('roles.name')
        ->orderBy('id','desc')
        ->get();
    }
}
