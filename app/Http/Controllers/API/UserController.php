<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Branch;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $users = User::all();
        return $this->success(UserResource::collection($users), 'Users fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'role_id' => 'required',
            'branch_id' => 'required',
            'tenant_id' => 'required',
            'name' => 'required',  
            'email' => 'required|email|unique:tenants', 
            'mobile_no' => 'required|numeric', 
            'password' => 'required',
            //'is_active' => 'required',
           
           
        ]);
       
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $user = User::create($input);
        return $this->success(new UserResource($user), 'User created successfully.');
    }
   
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return $this->error('User not found.', 404);
        }
        return $this->success(new UserResource($user), 'User fetched successfully.');
    }
    
   
    public function update(Request $request, User $user)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'role_id' => 'required',
            'branch_id' => 'required',
            'tenant_id' => 'required',
            'name' => 'required',  
            'email' => 'required|email|unique:tenants', 
            'mobile_no' => 'required|numeric', 
            'password' => 'required',
            //'is_active' => 'required',
            
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }
        $user->role_id = $input['role_id'];
        $user->branch_id = $input['branch_id'];
        $user->tenant_id = $input['tenant_id'];
        $user->name = $input['name'];       
        $user->email = $input['email'];
        $user->mobile_no = $input['mobile_no'];
        $user->password = $input['password'];
        // $user->is_active = $input['is_active'];
        $user->save();
   
        return $this->success($user, "User updated successfully.", 200);
    }
   
    public function destroy(User $user)
    {
        $user->delete();
        return $this->success([], 'User deleted successfully.');
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = !$user->is_active;
        $user->save();        
        return $this->success($user, "User updated successfully.", 200);
    }
}
