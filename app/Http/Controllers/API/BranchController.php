<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Branch;
use App\Http\Resources\Branch as BranchResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class BranchController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $branches = Branch::all();
        return $this->success(BranchResource::collection($branches), 'Branch fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'tenant_id' => 'required',
            'name' => 'required',  
            'email' => 'required|email|unique:branches', 
            //'no_of_terminals' => 'required|integer|min:1',
            'location' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric', 
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $branch = Branch::create($input);
        return $this->success(new BranchResource($branch), 'Branch created successfully.');
    }
   
    public function show($id)
    {
        $branch = Branch::find($id);
        if (is_null($branch)) {
            return $this->error('Branch not found.', 404);
        }
        return $this->success(new BranchResource($branch), 'Branch fetched successfully.');
    }
    
   
    public function update(Request $request, Branch $branch)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'tenant_id' => 'required',
            'name' => 'required',  
            'email' => 'required|email|unique:tenants', 
           // 'no_of_terminals' => 'required|integer|min:1',
            'location' => 'required',
            'address' => 'required',
            'phone_number' => 'required|numeric', 
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }
        $branch->tenant_id = $input['tenant_id'];
        $branch->name = $input['name'];       
        $branch->email = $input['email'];
        //$branch->no_of_terminals = $input['no_of_terminals'];
        $branch->address = $input['address'];
        $branch->location = $input['location'];
        $branch->phone_number = $input['phone_number'];
        $branch->save();
   
        return $this->success($branch, "Branch updated successfully.", 200);
    }
   
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return $this->success([], 'Branch deleted successfully.');
    }
}
