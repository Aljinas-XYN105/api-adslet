<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsCampaign;
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
        $input = $request->all();
        $input['start_date'] = date('Y-m-d', strtotime($input['start_date']));
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
            'status' => SmsCampaign::STATUS_NOT_STARTED,
            'queue_status' => 'pending',
        ]);

        SendSmsCampaignJob::dispatch($smscampaign->id);

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