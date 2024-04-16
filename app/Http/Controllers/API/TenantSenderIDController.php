<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TenantSenderID;
use App\Http\Resources\TenantSenderID as TenantSenderIDResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;

class TenantSenderIDController extends Controller
{
    use ApiResponser;
    public function index()
    {
        $tenantsenderids = TenantSenderID::where('tenant_id',Auth::User()->tenant_id)->get();
        return $this->success($tenantsenderids, 'TenantSenderID fetched successfully.');
    }
}
