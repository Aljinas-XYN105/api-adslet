<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SmsHistory;
use App\Models\Tenant;
use App\Models\TenantSmsGateway;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SMSController extends Controller
{

    use ApiResponser;

    public function sendsms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'api_id' => 'required',
            'api_password' => 'required',
            'phonenumber' => 'required|numeric|digits_between:8,15',
            'textmessage' => 'required|string',
            'msg_type' => 'nullable|in:1,2',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }
        $api_id = $request->input('api_id');
        $api_password = $request->input('api_password');
        $phonenumber = $request->input('phonenumber');
        $textmessage = $request->input('textmessage');
        $msg_type = $request->input('msg_type', 1);

        $userVerified = $this->verifyUser($api_id, $api_password);
        // return $userVerified;
        if ($userVerified) {
            $tenant_id = $userVerified->tenant_id;
            $sender_id = $userVerified->sender_id;
            $amount = $userVerified->amount;


            $tenantSmsGateway = TenantSmsGateway::where('tenant_id', $tenant_id)->first();

            if (!$tenantSmsGateway) {
                return $this->error('Tenant SMS gateway not found.', 404);
            }

            $msg_count = strlen($textmessage) > 160 ? 2 : 1;
            $total_msg_price = $msg_count * $amount;

            // Update tenant's wallet
            $tenant = Tenant::where('id', $tenant_id)->first();

            if (!$tenant) {
                return $this->error('Tenant not found.', 404);
            }

            if ($tenant->wallet < $total_msg_price) {
                return $this->error('Insufficient funds.', 400);
            }

            $newWalletBalance = $tenant->wallet - $total_msg_price;

            $tenant->update(['wallet' => $newWalletBalance]);

            // Assuming `send_ooredoo_sms` is a custom function.
           $ooredoo_response = send_ooredoo_sms($sender_id, $phonenumber, $textmessage, $msg_type);

            $smsHistory = SmsHistory::create([
                'tenantsms_id' => $tenantSmsGateway->id,
                'tenant_id' => $tenant_id,
                'msg_length' => strlen($textmessage),
                'msg_count' => $msg_count,
                'msg_price' => $total_msg_price,
                'phonenumber'=> $request->input('phonenumber'),
                'textmessage'=> $request->input('textmessage'),
                'response' => json_encode($ooredoo_response),
                'msg_type'=>$request->input('msg_type', 1),
                'status'=>1,
            ]);

            if ($smsHistory) {
                return $this->success("SMS sent successfully.", 200);
            } else {
                return $this->error('Failed to save SMS history.', 500);
            }
        } else {
            return $this->error('Invalid API credentials.', 401);
        }

        // if ($userVerified) {

        //     send_ooredoo_sms($sender_id, $phonenumber, $textmessage, $msg_type);
        //     return $this->success("SMS sent successfully.", 200);
        // } else {

        //     return $this->error('Invalid API credentials.', 401);
        // }
    }

    public function verifyUser($api_id, $api_password)
    {
        // return $api_id;
        $tenantsmsgateway = TenantSmsGateway::where('api_id', $api_id)->first();

        if ($tenantsmsgateway && $tenantsmsgateway->api_password === $api_password) {
            return $tenantsmsgateway;
        } else {
            return false;
        }
    }
}
