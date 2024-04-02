<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    static public function getSingle($id)
    {
        return Role::find($id);
      
    }

    static public function getRole()
    {
        return Role::select('roles.*')
        ->orderBy('id','desc')
        ->get();
    }
}
