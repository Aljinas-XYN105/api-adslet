<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedbackReport;
use App\Http\Resources\FeedbackReport as FeedbackReportResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;

class FeedbackReportController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $feedbackreports = FeedbackReport::all();
        return $this->success(FeedbackReportResource::collection($feedbackreports), 'FeedbackReport fetched successfully.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
           
            'terminal_id' => 'required', 
            'feedback_group_id' => 'required', 
            'total_feedbacks' => 'required', 
            'average_rating' => 'required', 
            'low_rank_question' => 'required', 
            'high_rank_question' => 'required', 
           
        ]);
        
        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        $feedbackreport = FeedbackReport::create([
            'terminal_id' => $input['terminal_id'],
            'feedback_group_id' => $input['feedback_group_id'],
            'total_feedbacks' => $input['total_feedbacks'],
            'average_rating' => $input['average_rating'],
            'low_rank_question' => $input['low_rank_question'],
            'high_rank_question' => $input['high_rank_question'],
        ]);
        
        return $this->success(new FeedbackReportResource($feedbackreport), 'FeedbackReport created successfully.');
    }
   
    public function show($id)
    {
        $feedbackreport = FeedbackReport::find($id);
        if (is_null($feedbackreport)) {
            return $this->error('FeedbackQuestion not found.', 404);
        }
        return $this->success(new FeedbackReportResource($feedbackreport), 'FeedbackReport fetched successfully.');
    }
    
    public function update(Request $request, FeedbackReport $feedbackreport)
            {
             $input = $request->all();
             

               $validator = Validator::make($input, [
                'terminal_id' => 'required', 
                'feedback_group_id' => 'required', 
                'total_feedbacks' => 'required', 
                'average_rating' => 'required', 
                'low_rank_question' => 'required', 
                'high_rank_question' => 'required',
            ]);

                if ($validator->fails()) {
                    return $this->error('Validation Error.', 422, $validator->errors());
                }

                $feedbackreport->update([
                    'terminal_id' => $input['terminal_id'],
                    'feedback_group_id' => $input['feedback_group_id'],
                    'total_feedbacks' => $input['total_feedbacks'],
                    'average_rating' => $input['average_rating'],
                    'low_rank_question' => $input['low_rank_question'],
                    'high_rank_question' => $input['high_rank_question'],
                ]);
            

                return $this->success($feedbackreport, "FeedbackReport updated successfully.", 200);
            }
   
            public function destroy(FeedbackReport $feedbackreport)
            {
                $feedbackreport->delete();
                return $this->success([], 'FeedbackReport deleted successfully.');
            }

}
