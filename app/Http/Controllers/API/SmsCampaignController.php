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

       
        $input['phone_number'] = explode(',', $input['phone_number']);

        
        $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
        $input['end_date'] = date('Y-m-d', strtotime($input['end_date']));

        $validator = Validator::make($input, [
            'smsgroup_id' => 'required',
            'name' => 'required',  
            'description' => 'required', 
            'message' => 'required',
            'phone_number' => 'required|array',
            'phone_number.*' => 'numeric', 
            'start_date' => 'required|date',
            'end_date' => 'required|date',
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
   
       
        $input['phone_number'] = explode(',', $input['phone_number']);

      
        $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
        $input['end_date'] = date('Y-m-d', strtotime($input['end_date']));

        $validator = Validator::make($input, [
            'smsgroup_id' => 'required',
            'name' => 'required',  
            'description' => 'required', 
            'message' => 'required',
            'phone_number' => 'required|array',
            'phone_number.*' => 'numeric', 
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }

        $smscampaign->update($input);
   
        return $this->success($smscampaign, "SmsCampaign updated successfully.", 200);
    }
   
    public function destroy(SmsCampaign $smscampaign)
    {
        $smscampaign->delete();
        return $this->success([], 'SmsCampaign deleted successfully.');
    }
}
