<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TenantSmsGateway;
use App\Models\SmsHistory;
use App\Http\Resources\SmsHistory as SmsHistoryResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class SmsHistoryController extends Controller
{
    use ApiResponser;
    public function index()
    {
        $smshistory = SmsHistory::all();
        return $this->success(SmsHistoryResource::collection($smshistory), 'SmsHistory fetched successfully.');
    }
}
