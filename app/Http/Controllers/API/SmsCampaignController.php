<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsCampaign;
use App\Models\CampaignHistory;
use App\Models\SmsCampignContact;
use App\Models\CampaignGroup;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\SmsCampaign as SmsCampaignResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use App\Jobs\SendSmsCampaignJob;

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

        $user = Auth::user();

        $input = $request->all();
        $input['contact_no'] = explode(',', $input['contact_no']);
        $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'message' => 'required',
            'smsgroup_id' => 'required',
            'type' => 'required|boolean',
            'start_date' => 'required',
            'start_time' => 'required',
            'contact_no' => 'required|array',
            'contact_no.*' => 'numeric',
            'status' => 'required|integer',
            'queue_status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $smscampaign = SmsCampaign::create([
            'name' => $input['name'],
            'description' => $input['description'],
            'message' => $input['message'],
            'type' => $input['type'],
            // 'contact_no' => $input['contact_no'],
            'start_date' => $input['start_date'],
            'start_time' => $input['start_time'],
            'status' => SmsCampaign::STATUS_NOT_STARTED,
            'queue_status' => 'pending',
        ]);

        if ($smscampaign) {
            // $smscampigncontact = SmsCampignContact::create([
            //     'sms_campaign_id' => $smscampaign->id,
            //     'contact_no' => $input['contact_no'],
            // ]);
            foreach ($input['contact_no'] as $contact) {
                $smscampigncontact = SmsCampignContact::create([
                    'sms_campaign_id' => $smscampaign->id,
                    'contact_no' => $contact,
                ]);
                foreach ($input['smsgroup_id'] as $smsgroup_id) {
                    $campaigngroup = CampaignGroup::create([
                        'sms_campaign_id' => $smscampaign->id,
                        'smsgroup_id' => $smsgroup_id,
                    ]);
                }
            }
            // SendSmsCampaignJob::dispatch($smscampaign->id);

            $campaignhistory = CampaignHistory::create([
                'sms_campaign_id' => $smscampaign->id,
                'message' => $smscampaign->message,
                'user_id' => Auth::User()->id,            
                'date' => now()->toDateString(),
                'time' => now()->toTimeString(),
                'status' => $smscampaign->status,
                'queue_status' => $smscampaign->queue_status,
            ]);
        }
        return $this->success(new SmsCampaignResource($smscampaign), 'SmsCampaign created successfully.');
    }
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'description' => 'required',
    //         'message' => 'required',
    //         'type' => 'required|boolean',
    //         'start_date' => 'required|date',
    //         'start_time' => 'required',
    //         'status' => 'required|integer',
    //         'queue_status' => 'nullable|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->error('Validation Error', 422, $validator->errors());
    //     }

    //     $input = $validator->validated();
    //     $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
    //     $input['queue_status'] = 'pending';
    //     $smscampaign = SmsCampaign::create($input);

    //     if (!$smscampaign) {
    //         return $this->error('Failed to create SmsCampaign', 500);
    //     }


    //     SendSmsCampaignJob::dispatch($smscampaign->id);
    //     $campaignhistory = CampaignHistory::create([
    //         'sms_campaign_id' => $smscampaign->id,
    //         'user_id' => 1,
    //         'date' => now()->toDateString(),
    //         'time' => now()->toTimeString(),
    //         'status' => SmsCampaign::STATUS_NOT_STARTED,
    //     ]);

    //     return $this->success(new SmsCampaignResource($smscampaign), 'SmsCampaign created successfully.');
    // }
    public function show($id)
    {
        $smscampaign = SmsCampaign::find($id);
        if (is_null($smscampaign)) {
            return $this->error('SmsCampaign not found.', 404);
        }
        return $this->success(new SmsCampaignResource($smscampaign), 'SmsCampaign fetched successfully.');
    }

    public function jobs($status){
        if($status == 1){
            // check campaign que status
            // start if que sattus is 0
        }
    }
    public function update(Request $request, SmsCampaign $smscampaign)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'message' => 'required',
            'type' => 'required|boolean',
            'start_date' => 'required',
            'start_time' => 'required',
            'status' => 'required|integer',
            'queue_status' => 'nullable|string',
        ]);

        $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));

        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }

        $smsCampaign->name = $input['name'];
        $smsCampaign->description = $input['description'];
        $smsCampaign->message = $input['message'];
        $smsCampaign->type = $input['type'];
        $smsCampaign->start_date = $input['start_date'];
        $smsCampaign->start_time = $input['start_time'];
        $smsCampaign->status = $input['status'];
        $smsCampaign->queue_status = $input['queue_status'] ?? $smsCampaign->queue_status;
        $smsCampaign->save();

        return $this->success($smscampaign, "SmsCampaign updated successfully.", 200);
    }

    public function destroy(SmsCampaign $smscampaign)
    {
        $smscampaign->delete();
        return $this->success([], 'SmsCampaign deleted successfully.');
    }
}
