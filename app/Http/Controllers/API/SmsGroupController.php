<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsGroup;
use App\Http\Resources\SmsGroup as SmsGroupResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;

class SmsGroupController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $smsgroups = SmsGroup::all();
        return $this->success(SmsGroupResource::collection($smsgroups), 'SmsGroups fetched successfully.');
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

        $smsgroup = SmsGroup::create($input);
        return $this->success(new SmsGroupResource($smsgroup), 'SmsGroup created successfully.');
    }
   
    public function show($id)
    {
        $smsgroup = SmsGroup::find($id);
        if (is_null($smsgroup)) {
            return $this->error('SmsGroup not found.', 404);
        }
        return $this->success(new SmsGroupResource($smsgroup), 'SmsGroup fetched successfully.');
    }
    
   
    public function update(Request $request, SmsGroup $smsgroup)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 400, $validator->errors());
        }
   
        $smsgroup->name = $input['name'];
        $smsgroup->save();
   
        return $this->success($smsgroup, "SmsGroup updated successfully.", 200);
    }
   
    public function destroy(SmsGroup $smsgroup)
    {
        $smsgroup->delete();
        return $this->success([], 'SmsGroup deleted.');
    }
}
