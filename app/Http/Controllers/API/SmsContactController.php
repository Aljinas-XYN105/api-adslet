<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsContact;
use App\Http\Resources\SmsContact as SmsContactResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Str;

class SmsContactController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $smscontacts = SmsContact::all();
        return $this->success(SmsContactResource::collection($smscontacts), 'SmsContacts fetched successfully.');
    }
    
    public function store(Request $request)
    {

        $input = $request->all();

        //$input['phone_number'] = explode(',', $input['phone_number']);
        $validator = Validator::make($input, [
            'smsgroup_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number'=>'required',
            // 'phone_number.*' => 'numeric', 
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }
        $smscontact = SmsContact::create([
            'smsgroup_id' => $input['smsgroup_id'],
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'phone_number' => $input['phone_number'],
        ]);
        //$smscontact = SmsContact::create($input);
        return $this->success(new SmsContactResource($smscontact), 'SmsContact created successfully.');
    }
   
    public function show($id)
    {
        $smscontact = SmsContact::find($id);
        if (is_null($smscontact)) {
            return $this->error('Smscontact not found.', 404);
        }
        return $this->success(new SmsContactResource($smscontact), 'SmsContact fetched successfully.');
    }
    
   
    public function update(Request $request, SmsContact $smscontact)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'smsgroup_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->error('Validation Error.', 400, $validator->errors());
        }
   
        $smscontact->smsgroup_id = $input['smsgroup_id'];
        $smscontact->first_name = $input['first_name'];
        $smscontact->last_name = $input['last_name'];
        $smscontact->phone_number = $input['phone_number'];
        $smscontact->save();
   
        return $this->success($smscontact, "SmsContact updated successfully.", 200);
    }
   
    public function destroy(SmsContact $smscontact)
    {
        $smscontact->delete();
        return $this->success([], 'SmsContact deleted.');
    }
}
