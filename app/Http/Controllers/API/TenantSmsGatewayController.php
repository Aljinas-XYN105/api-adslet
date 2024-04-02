<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TenantSmsGateway;
use App\Models\SmsHistory;
use App\Http\Resources\TenantSmsGateway as TenantSmsGatewayResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;


class TenantSmsGatewayController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'tenant_id' => 'required',
            'api_id' => 'required',
            'api_password' => 'required',
            'sender_id' => 'required',
            'phonenumber' => 'required',
            'textmessage' => 'required',
            'amount' => 'required',
            'msg_type' => 'nullable',
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }
    

        $tenantsmsgateway = TenantSmsGateway::create($input);
    
      
        return $this->success($tenantsmsgateway, 'TenantSmsGateway created successfully.');
    }

    public function show($id)
    {
        $tenantsmsgateway = TenantSmsGateway::find($id);
        if (is_null($tenantsmsgateway)) {
            return $this->error('TenantSmsGateway not found.', 404);
        }
        return $this->success(new TenantSmsGatewayResource($tenantsmsgateway), 'TenantSmsGateway fetched successfully.');
    }

    public function update(Request $request, TenantSmsGateway $tenantsmsgateway)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'tenant_id' => 'required',
            'api_id' => 'required',
            'api_password' => 'required',
            'sender_id' => 'required',
            'phonenumber' => 'required',
            'textmessage' => 'required',
            'amount' => 'required',
            'msg_type' => 'nullable',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }

        if (is_null($tenantsmsgateway)) {
            return $this->error('TenantSmsGateway not found.', 404);
        }
   
        $tenantsmsgateway->tenant_id = $input['tenant_id'];
        $tenantsmsgateway->api_id = $input['api_id'];
        $tenantsmsgateway->api_password = $input['api_password'];
        $tenantsmsgateway->sender_id = $input['sender_id'];
        $tenantsmsgateway->phonenumber = $input['phonenumber'];
        $tenantsmsgateway->textmessage = $input['textmessage'];
        $tenantsmsgateway->amount = $input['amount'];
        $tenantsmsgateway->msg_type = $input['msg_type'];
        $tenantsmsgateway->save();
   
        return $this->success(new TenantSmsGatewayResource($tenantsmsgateway), "TenantSmsGateway updated successfully.", 200);

    }
   
   
   
}
