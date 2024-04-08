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

       
        // $input['phone_number'] = explode(',', $input['phone_number']);

        
        // $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
        // $input['end_date'] = date('Y-m-d', strtotime($input['end_date']));

        $validator = Validator::make($input, [
            'name' => 'required',  
            'description' => 'required', 
            'message' => 'required',
            'type' => 'required',
            'start_date' => 'required', 
            'start_time' => 'required',
            'status' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $smscampaign = SmsCampaign::create([
            'name' => $input['name'],
            'description' => $input['description'],
            'message' => $input['message'],
            'type' => $input['type'],
            'start_date' => $input['start_date'],
            'start_time' => $input['start_time'],
            'status' => $input['status'],
           
        ]);
        
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
                    'name' => 'required',  
                    'description' => 'required', 
                    'message' => 'required',
                    'type' => 'required',
                    'start_date' => 'required', 
                    'start_time' => 'required',
                    'status' => 'required',
                ]);

                if ($validator->fails()) {
                    return $this->error('Validation Error.', 422, $validator->errors());
                }

                $smscampaign->name = $input['name'];
                $smscampaign->description = $input['description'];
                $smscampaign->message = $input['message'];
                $smscampaign->type = $input['type'];
                $smscampaign->start_date = $input['start_date'];
                $smscampaign->start_time = $input['start_time'];
                $smscampaign->status = $input['status'];
                $smscampaign->save();

                return $this->success($smscampaign, "SmsCampaign updated successfully.", 200);
            }
   
            public function destroy(SmsCampaign $smscampaign)
            {
                $smscampaign->delete();
                return $this->success([], 'SmsCampaign deleted successfully.');
            }
}
