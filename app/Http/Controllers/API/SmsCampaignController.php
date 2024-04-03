<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsCampaign;
use App\Http\Resources\SmsCampaign as SmsCampaignResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
class SmsCampaignController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $smscampaigns = SmsCampaign::all();
        return $this->success(SmsCampaignResource::collection($smscampaigns), 'SmsCampaign fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'smsgroup_id'=>'required',
            'name' => 'required',  
            'description' => 'required', 
            'message' => 'required',
            'phone_number' => 'required|numeric', 
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $smscampaign = SmsCampaign::create($input);
        return $this->success(new SmsCampaignResource($smscampaign), 'SmsCampaign created successfully.');
    }
   
    public function show($id)
    {
        $smscampaign = SmsCampaign::find($id);
        if (is_null($smscampaign)) {
            return $this->error('SmsCampaign not found.', 404);
        }
        return $this->success(new SmsCampaignResource($smscampaign), 'SmsCampaign fetched successfully.');
    }
    
   
    public function update(Request $request, SmsCampaign $smscampaign)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'smsgroup_id'=>'required',
            'name' => 'required',  
            'description' => 'required', 
            'message' => 'required',
            'phone_number' => 'required|numeric', 
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }
        $smscampaign->smsgroup_id = $input['smsgroup_id'];
        $smscampaign->name = $input['name'];       
        $smscampaign->description = $input['description'];
        $smscampaign->message = $input['message'];
        $smscampaign->phone_number = $input['phone_number'];
        $smscampaign->start_date = $input['start_date'];
        $smscampaign->end_date = $input['end_date'];
        $smscampaign->save();
   
        return $this->success($smscampaign, "SmsCampaign updated successfully.", 200);
    }
   
    public function destroy(SmsCampaign $smscampaign)
    {
        $smscampaign->delete();
        return $this->success([], 'SmsCampaign deleted successfully.');
    }
}
