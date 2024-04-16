<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackQuestion;
use App\Http\Resources\FeedbackQuestion as FeedbackQuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
class FeedbackQuestionController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $feedbackquestions = FeedbackQuestion::all();
        return $this->success(FeedbackQuestionResource::collection($feedbackquestions), 'FeedbackQuestion fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
                'tenant_id'=> 'required',
                'branch_id'=> 'required',
                'question' => 'required|string', 
                 'sort_order' => 'required|integer', 
                'answer_text_box' => 'required|boolean',
           
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        if (isset($input['answer_text_box'])) {
            // If set, assign its value
            $answerTextBoxValue = $input['answer_text_box'];
        } else {
            // If not set, assign a default value
            $answerTextBoxValue = false;
        }

        $feedbackquestion = FeedbackQuestion::create([
            'tenant_id'=> 1,
            'branch_id'=> 1,
            'question' => $input['question'],
            'sort_order' => $input['sort_order'], 
            'answer_text_box' => $answerTextBoxValue = $input['answer_text_box'] ?? false,
          
        ]);
        
        return $this->success(new FeedbackQuestionResource($feedbackquestion), 'FeedbackQuestion created successfully.');
    }
   
    public function show($id)
    {
        $feedbackquestion = FeedbackQuestion::find($id);
        if (is_null($feedbackquestion)) {
            return $this->error('FeedbackQuestion not found.', 404);
        }
        return $this->success(new FeedbackQuestionResource($feedbackquestion), 'FeedbackQuestion fetched successfully.');
    }
    
    public function update(Request $request, FeedbackQuestion $feedbackquestion)
            {
             $input = $request->all();
             

               $validator = Validator::make($input, [
                'tenant_id'=> 1,
                'branch_id'=> 1,
                'question' => 'required|string', 
                'sort_order' => 'required|integer', 
                'answer_text_box' => 'required|boolean',
            ]);

                if ($validator->fails()) {
                    return $this->error('Validation Error.', 422, $validator->errors());
                }

                $feedbackquestion->update([
                    'tenant_id'=> $input['tenant_id'],
                    'branch_id'=> $input['branch_id'],
                    'question' => $input['question'],
                    'sort_order' => $input['sort_order'], 
                    'answer_text_box' => $answerTextBoxValue = $input['answer_text_box'] ?? false,
                ]);
            

                return $this->success($feedbackquestion, "FeedbackQuestion updated successfully.", 200);
            }
   
            public function destroy(FeedbackQuestion $feedbackquestion)
            {
                $feedbackquestion->delete();
                return $this->success([], 'FeedbackQuestion deleted successfully.');
            }

}
