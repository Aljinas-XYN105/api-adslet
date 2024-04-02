<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionStatus;
use App\Models\Branch;
use App\Models\Question;
use App\Http\Resources\QuestionStatus as QuestionStatusResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class QuestionStatusController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $questionstatuses = QuestionStatus::all();
        return $this->success(QuestionStatusResource::collection($questionstatuses), 'QuestionStatus fetched successfully.');
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

        $questionstatus = QuestionStatus::create($input);
        return $this->success(new QuestionStatusResource($questionstatus), 'QuestionStatus created successfully.');
    }
   
    public function show($id)
    {
        $questionstatus = QuestionStatus::find($id);
        if (is_null($questionstatus)) {
            return $this->error('QuestionStatus not found.', 404);
        }
        return $this->success(new QuestionStatusResource($questionstatus), 'QuestionStatus fetched successfully.');
    }
    
   
    public function update(Request $request, QuestionStatus $questionstatus)
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
        $questionstatus->question_id = $input['question_id'];
        $questionstatus->terminal_id = $input['terminal_id'];
        $questionstatus->status = $input['status'];       
        $questionstatus->save();
   
        return $this->success($questionstatus, "QuestionStatus updated successfully.", 200);
    }
   
    public function destroy(QuestionStatus $questionstatus)
    {
        $questionstatus->delete();
        return $this->success([], 'QuestionStatus deleted successfully.',200);
    }
}
