<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Http\Resources\Tenant as TenantResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $tenants = Tenant::all();
        return $this->success(TenantResource::collection($tenants), 'Tenant fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();

        $apiKey = $this->generateApiKey($input['name']);
        $apiPassword = $this->generateApiPassword();

        // Add API key and password to input data
        $input['api_key'] = $apiKey;
        $input['api_password'] = $apiPassword;


        $validator = Validator::make($input, [
            'name' => 'required',  
            'slug' => 'required|unique:tenants', 
            'email' => 'required|email|unique:tenants', 
            'no_of_terminals' => 'required|integer|min:1', 
            'address1' => 'required',
            'address2' => 'required',
            'phone_number' => 'required|numeric', 
            'wallet' => 'required|numeric',

        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $tenant = Tenant::create($input);
        return $this->success(new TenantResource($tenant), 'Tenant created successfully.', 200);
    }
   
    public function show($id)
    {
        $tenant = Tenant::find($id);
        if (is_null($tenant)) {
            return $this->error('Tenant not found.', 404);
        }
        return $this->success(new TenantResource($tenant), 'Tenant fetched successfully.', 200);
    }
    
    public function update(Request $request, $id)
    {
        $input = $request->all();
    
        $validator = Validator::make($input, [
            'name' => 'required',  
            'slug' => 'required|unique:tenants,slug,'.$id, 
            'email' => 'required|email|unique:tenants,email,'.$id, 
            'no_of_terminals' => 'required|integer|min:1', 
            'address1' => 'required',
            'address2' => 'required',
            'phone_number' => 'required|numeric', 
            'wallet' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return $this->error('Validation Error.', 400, $validator->errors());
        }
    
        // Retrieve the existing tenant
        $tenant = Tenant::find($id);
        if (is_null($tenant)) {
            return $this->error('Tenant not found.', 404);
        }
    
        // Update tenant data
        $tenant->name = $input['name'];
        $tenant->slug = $input['slug'];
        $tenant->email = $input['email'];
        $tenant->no_of_terminals = $input['no_of_terminals'];
        $tenant->address1 = $input['address1'];
        $tenant->address2 = $input['address2'];
      
        $tenant->phone_number = $input['phone_number'];
        $tenant->wallet = $input['wallet'];
        $tenant->save();
    
        // Generate new API key and password
        // $apiKey = $this->generateApiKey($input['name']);
        // $apiPassword = $this->generateApiPassword();
    
        // Assign API key and password to input data
        // $tenant->api_key = $apiKey;
        // $tenant->api_password = $apiPassword;
        // $tenant->save();
    
        return $this->success($tenant, "Tenant updated successfully.", 200);
    }
    // public function update(Request $request, Tenant $tenant)
    // {
    //     $input = $request->all();
   
    //     $validator = Validator::make($input, [
    //         'name' => 'required',  
    //         'slug' => 'required|unique:tenants', 
    //         'email' => 'required|email|unique:tenants', 
    //         'no_of_terminals' => 'required|integer|min:1', 
    //         'address' => 'required',
    //         'phone_number' => 'required|numeric', 
    //         'wallet' => 'required|numeric',
    //     ]);
   
    //     if ($validator->fails()) {
    //         return $this->error('Validation Error.', 400, $validator->errors());
    //     }
   
    //     $tenant->name = $input['name'];
    //     $tenant->slug = $input['slug'];
    //     $tenant->email = $input['email'];
    //     $tenant->no_of_terminals = $input['no_of_terminals'];
    //     $tenant->address = $input['address'];
    //     $tenant->phone_number = $input['phone_number'];
    //     $tenant->wallet = $input['wallet'];
    //     $tenant->save();

    //     //  // Generate new API key and password
    //     // $apiKey = $this->generateApiKey($input['name']);
    //     // $apiPassword = $this->generateApiPassword();

    //     // // Assign API key and password to input data
    //     // $tenant->api_key = $apiKey;
    //     // $tenant->api_password = $apiPassword;
    //     // $tenant->save();
   
    //     return $this->success($tenant, "Tenant updated successfully.", 200);
    // }
   
    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return $this->success([], 'Tenant deleted successfully.');
    }

//-------------------------------------------------------------------------------------------
   

    private function generateApiKey($name)
        {
        
            $nameAbbreviation = strtoupper(substr($name, 0, 4));
        
            $timestamp = date('YmdHis');
        
            $apiKey = $nameAbbreviation . '_' . $timestamp;

            return $apiKey;
        }

   
    private function generateApiPassword()
        {
        
            $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $numerics = '0123456789';
            $specialChars = '!@#$%^&*()-_=+';

        
            $characters = $alphabets . $numerics . $specialChars;

        
            $shuffledCharacters = str_shuffle($characters);

        
            $passwordLength = 12; 
            $randomPassword = substr($shuffledCharacters, 0, $passwordLength);

            return $randomPassword;
        }
}
