<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TerminalStatus;
use App\Models\Branch;
use App\Models\Question;
use App\Http\Resources\TerminalStatus as TerminalStatusResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class TerminalStatusController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $terminalstatuses = TerminalStatus::all();
        return $this->success(TerminalStatusResource::collection($terminalstatuses), 'TerminalStatus fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'branch_id' => 'required',
            'terminal_name' => 'required',
            'terminal_code' => 'required',
            'status' => 'required|boolean',
             
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $terminalstatus = TerminalStatus::create($input);
        return $this->success(new TerminalStatusResource($terminalstatus), 'TerminalStatus created successfully.');
    }
   
    public function show($id)
    {
        $terminalstatus = TerminalStatus::find($id);
        if (is_null($terminalstatus)) {
            return $this->error('TerminalStatus not found.', 404);
        }
        return $this->success(new TerminalStatusResource($terminalstatus), 'TerminalStatus fetched successfully.');
    }
    
   
    public function update(Request $request, TerminalStatus $terminalstatus)
    {
        $input = $request->all();
           $validator = Validator::make($input, [
            'branch_id' => 'required',
            'terminal_name' => 'required',
            'terminal_code' => 'required',
            'status' => 'required|boolean',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }
        $terminalstatus->branch_id = $input['branch_id'];
        $terminalstatus->terminal_name = $input['terminal_name'];
        $terminalstatus->terminal_code = $input['terminal_code'];
        $terminalstatus->status = $input['status'];       
        $terminalstatus->save();
   
        return $this->success($terminalstatus, "TerminalStatus updated successfully.", 200);
    }
   
    public function destroy(TerminalStatus $terminalstatus)
    {
        $terminalstatus->delete();
        return $this->success([], 'TerminalStatus deleted successfully.',200);
    }
}
