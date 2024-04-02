<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Branch;
use App\Models\Question;
use App\Http\Resources\Question as QuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class QuestionController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $questions = Question::all();
        return $this->success(QuestionResource::collection($questions), 'Question fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'branch_id' => 'required',
            'tenant_id' => 'required',
            'questions' => 'required',
            'answer_type'=>'required',
            'is_active' => 'required|boolean',
             
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $question = Question::create($input);
        return $this->success(new QuestionResource($question), 'Question created successfully.');
    }
   
    public function show($id)
    {
        $question = Question::find($id);
        if (is_null($question)) {
            return $this->error('Question not found.', 404);
        }
        return $this->success(new QuestionResource($question), 'Question fetched successfully.');
    }
    
   
    public function update(Request $request, Question $question)
    {
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'branch_id' => 'required',
            'tenant_id' => 'required',
            'questions' => 'required',
            'answer_type'=>'required',
            'is_active' => 'required|boolean',
        ]);
   
        if ($validator->fails()) {
            return $this->error('Validation Error.', 400, $validator->errors());
        }
        $question->branch_id = $input['branch_id'];
        $question->tenant_id = $input['tenant_id'];
        $question->questions = $input['questions'];  
        $question->answer_type = $input['answer_type'];  
        $question->is_active = $input['is_active'];       
        $question->save();
   
        return $this->success($question, "Question updated successfully.", 200);
    }
   
    public function destroy(Question $question)
    {
        $question->delete();
        return $this->success([], 'Question deleted successfully.',200);
    }
}
