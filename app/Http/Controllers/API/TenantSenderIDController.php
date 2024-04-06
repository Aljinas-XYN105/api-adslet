<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TenantSenderID;
use App\Http\Resources\TenantSenderID as TenantSenderIDResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
class TenantSenderIDController extends Controller
{
    use ApiResponser;
    public function index()
    {
        $tenantsenderids = TenantSenderID::all();
        return $this->success(TenantSenderIDResource::collection($tenantsenderids), 'TenantSenderID fetched successfully.');
    }
}
