<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Models\Branch;
use App\Models\Question;
use App\Http\Resources\Terminal as TerminalResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
class TerminalController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $terminal = Terminal::all();
        return $this->success(TerminalResource::collection($terminal), 'Terminal fetched successfully.');
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

        $terminal = Terminal::create($input);
        return $this->success(new TerminalResource($terminal), 'Terminal created successfully.');
    }
   
    public function show($id)
    {
        $terminal = Terminal::find($id);
        if (is_null($terminal)) {
            return $this->error('TerminalStatus not found.', 404);
        }
        return $this->success(new TerminalResource($terminal), 'Terminal fetched successfully.');
    }
    
   
    public function update(Request $request, Terminal $terminal)
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
        $terminal->branch_id = $input['branch_id'];
        $terminal->terminal_name = $input['terminal_name'];
        $terminal->terminal_code = $input['terminal_code'];
        $terminal->status = $input['status'];       
        $terminal->save();
   
        return $this->success($terminal, "Terminal updated successfully.", 200);
    }
   
    public function destroy(Terminal $terminal)
    {
        $terminal->delete();
        return $this->success([], 'Terminal deleted successfully.',200);
    }
}
