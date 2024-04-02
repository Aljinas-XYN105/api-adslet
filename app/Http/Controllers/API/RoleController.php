<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Http\Resources\Role as RoleResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class RoleController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $roles = Role::all();
        return $this->success(RoleResource::collection($roles), 'Roles fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $role = Role::create($input);
        return $this->success(new RoleResource($role), 'Role created successfully.');
    }
   
    public function show($id)
    {
        $role = Role::find($id);
        if (is_null($role)) {
            return $this->error('Role not found.', 404);
        }
        return $this->success(new RoleResource($role), 'Role fetched successfully.');
    }
    
   
    public function update(Request $request, Role $role)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 400, $validator->errors());
        }
   
        $role->name = $input['name'];
        $role->save();
   
        return $this->success($role, "Role updated successfully.", 200);
    }
   
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->success([], 'Role deleted.');
    }
}
