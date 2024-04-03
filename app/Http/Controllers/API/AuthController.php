<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends BaseController
{
    use ApiResponser;
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['api_token'] =  $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['email'] =  $authUser->email;
            $success['user'] =  $authUser;
            $success['tenant'] =  Tenant::whereId($authUser->tenant_id)->first();
            return $this->success($success, "User signed in.", 200);
        } else {
            return $this->error('Unauthorised', 401);
        }
    }

    public function verifyToken(Request $request)
    {
        $authUser = Auth::user();
        if (isset($authUser)) {
            $success['api_token'] =  $request['api_token'];
            $success['email'] =  $authUser->email;
            $success['user'] =  $authUser;
            $success['tenant'] =  Tenant::whereId($authUser->tenant_id)->first();
            return $this->success($success, "User signed in.", 200);
        } else {
            return $this->error('Unauthorised', 401);
        }
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error validation', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);


        try {
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyAuthApp')->plainTextToken;
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return $this->sendError('Error validation', ['email' => 'Email already exists.']);
            }

            return $this->sendError('Database error', ['error' => $e->getMessage()]);
        }
    }
}
