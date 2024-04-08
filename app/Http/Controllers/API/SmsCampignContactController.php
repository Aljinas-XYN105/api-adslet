<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsCampignContact;
use App\Http\Resources\SmsCampignContact as SmsCampignContactResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class SmsCampignContactController extends Controller
{
    use ApiResponser;


    public function index()
    {
        $smscampigncontacts = SmsCampignContact::all();
        return $this->success(SmsCampignContactResource::collection($smscampigncontacts), 'SmsCampignContact fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();

       
        $input['contact_no'] = explode(',', $input['contact_no']);

        
        // $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
        // $input['end_date'] = date('Y-m-d', strtotime($input['end_date']));

        $validator = Validator::make($input, [
            'sms_campaign_id' => 'required',  
            //'contact_no' => 'required', 
            'contact_no' => 'required|array',
            'contact_no.*' => 'numeric', 
            
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $smscampigncontact = SmsCampignContact::create([
            'sms_campaign_id' => $input['sms_campaign_id'],
            'contact_no' => $input['contact_no'],
           
        ]);
        
        return $this->success(new SmsCampignContactResource($smscampigncontact), 'SmsCampaign created successfully.');
    }
   
    public function show($id)
    {
        $smscampigncontact = SmsCampignContact::find($id);
        if (is_null($smscampigncontact)) {
            return $this->error('SmsCampignContact not found.', 404);
        }
        return $this->success(new SmsCampignContactResource($smscampigncontact), 'SmsCampaign fetched successfully.');
    }
    
    public function update(Request $request, SmsCampignContact $smscampigncontact)
            {

              
                $input = $request->all();
                $input['contact_no'] = explode(',', $input['contact_no']);

                $validator = Validator::make($input, [
                    'sms_campaign_id' => 'required',  
                    'contact_no' => 'required|array',
                    'contact_no.*' => 'numeric', 
                ]);

                if ($validator->fails()) {
                    return $this->error('Validation Error.', 422, $validator->errors());
                }

                $smscampigncontact->sms_campaign_id = $input['sms_campaign_id'];
                $smscampigncontact->contact_no = $input['contact_no'];
             
                $smscampigncontact->save();

                return $this->success($smscampigncontact, "SmsCampignContact updated successfully.", 200);
            }
   
            public function destroy(SmsCampignContact $smscampigncontact)
            {
                $smscampigncontact->delete();
                return $this->success([], 'SmsCampignContact deleted successfully.');
            }


   }
