<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TerminalQuestion;
use App\Models\Branch;
use App\Models\Question;
use App\Http\Resources\TerminalQuestion as TerminalQuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class TerminalQuestionController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $terminalquestions = TerminalQuestion::all();
        return $this->success(TerminalQuestionResource::collection($terminalquestions), 'QuestionStatus fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'question_id' => 'required',
            'terminal_id' => 'required',
            'status' => 'required|boolean',
             
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $terminalquestion = TerminalQuestion::create($input);
        return $this->success(new TerminalQuestionResource($terminalquestion), 'QuestionStatus created successfully.');
    }
   
    public function show($id)
    {
        $terminalquestion = TerminalQuestion::find($id);
        if (is_null($terminalquestion)) {
            return $this->error('QuestionStatus not found.', 404);
        }
        return $this->success(new TerminalQuestionResource($terminalquestion), 'QuestionStatus fetched successfully.');
    }
    
   
    public function update(Request $request, TerminalQuestion $terminalquestion)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'question_id' => 'required',
            'terminal_id' => 'required',
            'status' => 'required|boolean',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }
        $terminalquestion->question_id = $input['question_id'];
        $terminalquestion->terminal_id = $input['terminal_id'];
        $terminalquestion->status = $input['status'];       
        $terminalquestion->save();
   
        return $this->success($terminalquestion, "QuestionStatus updated successfully.", 200);
    }
   
    public function destroy(TerminalQuestion $terminalquestion)
    {
        $terminalquestion->delete();
        return $this->success([], 'QuestionStatus deleted successfully.',200);
    }
}
