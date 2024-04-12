<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackGroup;
use App\Http\Resources\FeedbackGroup as FeedbackGroupResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
class FeedbackGroupController extends Controller
{
    use ApiResponser;


    public function index()
    {
        $feedbackgroups = FeedbackGroup::all();
        return $this->success(FeedbackGroupResource::collection($feedbackgroups), 'FeedbackGroup fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();

       
        $validator = Validator::make($input, [
            'group_name' => 'required',
            'assign_questions' => 'required',
            'answer_type' => 'required',
            'expected_answers' => 'required',
            'answer_labels' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $feedbackgroup = FeedbackGroup::create([
            'group_name' => $input['group_name'],
            'assign_questions' => $input['assign_questions'],
            'answer_type' => $input['answer_type'],
            'expected_answers' => $input['expected_answers'],
            'answer_labels' => $input['answer_labels'],
        ]);
        
        return $this->success(new FeedbackGroupResource($feedbackgroup), 'FeedbackGroup created successfully.');
    }
   
    public function show($id)
    {
        $feedbackgroup = FeedbackGroup::find($id);
        if (is_null($feedbackgroup)) {
            return $this->error('FeedbackGroup not found.', 404);
        }
        return $this->success(new FeedbackGroupResource($feedbackgroup), 'FeedbackGroup fetched successfully.');
    }
    
    public function update(Request $request, FeedbackGroup $feedbackgroup)
            {

              
                $input = $request->all();
             

               $validator = Validator::make($input, [
                'group_name' => 'required',
                'assign_questions' => 'required',
                'answer_type' => 'required',
                'expected_answers' => 'required',
                'answer_labels' => 'required',
            ]);

                if ($validator->fails()) {
                    return $this->error('Validation Error.', 422, $validator->errors());
                }

                $feedbackgroup->update([
                    'group_name' => $input['group_name'],
                    'assign_questions' => $input['assign_questions'],
                    'answer_type' => $input['answer_type'],
                    'expected_answers' => $input['expected_answers'],
                    'answer_labels' => $input['answer_labels'],
                ]);
            

                return $this->success($feedbackgroup, "FeedbackGroup updated successfully.", 200);
            }
   
            public function destroy(FeedbackGroup $feedbackgroup)
            {
                $feedbackgroup->delete();
                return $this->success([], 'FeedbackGroup deleted successfully.');
            }

}
