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
            'tenant_id'=> 'required',
            'branch_id'=> 'required',
            'group_name' => 'required',
            'answer_type' => 'required',
            'no_expected_answers' => 'required',
            //'answer_labels' => 'required',
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $feedbackgroup = FeedbackGroup::create([
            'tenant_id'=> $input['tenant_id'],
            'branch_id'=> $input['branch_id'],
            'group_name' => $input['group_name'],
            'answer_type' => $input['answer_type'],
            'no_expected_answers' => $input['no_expected_answers'],
            //'answer_labels' => $input['answer_labels'] ?? '', 
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
                'tenant_id'=> 'required',
                'branch_id'=> 'required',
                'group_name' => 'required',
                'answer_type' => 'required',
                'no_expected_answers' => 'required',
                //'answer_labels' => 'required',
            ]);

                if ($validator->fails()) {
                    return $this->error('Validation Error.', 422, $validator->errors());
                }

                $feedbackgroup->update([
                    'tenant_id'=> $input['tenant_id'],
                    'branch_id'=> $input['branch_id'],
                    'group_name' => $input['group_name'],
                    'answer_type' => $input['answer_type'],
                    'no_expected_answers' => $input['no_expected_answers'],
                    //'answer_labels' => $input['answer_labels'] ?? '', 
                ]);
            

                return $this->success($feedbackgroup, "FeedbackGroup updated successfully.", 200);
            }
   
            public function destroy(FeedbackGroup $feedbackgroup)
            {
                $feedbackgroup->delete();
                return $this->success([], 'FeedbackGroup deleted successfully.');
            }

}
