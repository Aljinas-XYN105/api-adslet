<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terminal;
use App\Models\FeedbackGroup;
use App\Http\Resources\Terminal as TerminalResource;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
class TerminalController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $terminals = Terminal::all();
        return $this->success(TerminalResource::collection($terminals), 'Terminals fetched successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'tenant_id'=> 'required',
            'branch_id'=> 'required',
            'name' => 'required|string|max:255',
            'terminal_code' => 'required|string|max:255',
           // 'terminal_logo' => 'required',
            //'background_image' => 'required',
            'success_message' => 'nullable|string|max:255',
            'feedback_group_id' => 'required|array',
            'feedback_group_id.*' => 'exists:feedback_groups,id',
            'sms_sender_id' => 'nullable|string|max:255',
            
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', 422, $validator->errors());
        }

        // $terminalLogoPath = null;
        // if ($request->hasFile('terminal_logo')) {
        //     $terminalLogoPath = $request->file('terminal_logo')->store('terminal_logos');
        // }

        $terminal_logo_filename = null;
        $background_image_filename = null;
        
        if($request->hasFile('terminal_logo')){
            $file= $request->file('terminal_logo');
            $ext = $file->getClientOriginalExtension();
            $terminal_logo_filename =time().'.'.$ext;
            $file->move('assets/uploads/terminal_logos',$terminal_logo_filename);
            //$terminal ->terminal_logo = $terminal_logo_filename;
            }
            if($request->hasFile('background_image')){
                $file= $request->file('background_image');
                $ext = $file->getClientOriginalExtension();
                $background_image_filename =time().'.'.$ext;
                $file->move('assets/uploads/background_images',$background_image_filename);
               // $terminal ->background_image = $background_image_filename;
                }


        // $backgroundImagePath = null;
        // if ($request->hasFile('background_image')) {
        //     $backgroundImagePath = $request->file('background_image')->store('background_images');
        // }
        $successMessage = isset($input['success_message']) ? $input['success_message'] : 'Terminal created successfully.';

        $serializedfeedback_group_id = is_array($input['feedback_group_id']) ? implode(',', $input['feedback_group_id']) : null;
        $terminal = Terminal::create([
            'tenant_id' => 1,
            'branch_id' =>1,
            'name' => $input['name'],
            'terminal_code' => $input['terminal_code'],
            'success_message' =>$successMessage,
            'feedback_group_id' =>$serializedfeedback_group_id,
            'sms_sender_id' => $input['sms_sender_id'],
            'terminal_logo' =>  $terminal_logo_filename,
            'background_image' => $background_image_filename,
        ]);

        return $this->success(new TerminalResource($terminal),  "Terminal updated successfully.");
    }

    public function show($id)
    {
        $terminal = Terminal::find($id);
        if (is_null($terminal)) {
            return $this->error('Terminal not found.', 404);
        }
        return $this->success(new TerminalResource($terminal), 'Terminal fetched successfully.');
    }

    public function update(Request $request, Terminal $terminal)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'tenant_id'=> 'required',
            'branch_id'=> 'required',
            'name' => 'required|string|max:255',
            'terminal_code' => 'required|string|max:255',
            'terminal_logo' => 'required',
            'background_image' => 'required',
           // 'success_message' => 'nullable|string|max:255',
            'feedback_group_id' => 'nullable|integer',
            'sms_sender_id' => 'nullable|string|max:255',
        ]);
    
        if ($validator->fails()) {
            return $this->error('Validation Error.', 422, $validator->errors());
        }
    
        $terminal_logo_filename = null;
        $background_image_filename = null;
    
        if ($request->hasFile('terminal_logo')) {
            $path = 'assets/uploads/terminal_logos/' . $terminal->terminal_logo;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('terminal_logo');
            $ext = $file->getClientOriginalExtension();
            $terminal_logo_filename = time() . '.' . $ext;
            $file->move('assets/uploads/terminal_logos', $terminal_logo_filename);
        } else {
            $terminal_logo_filename = $terminal->terminal_logo;
        }
    
        if ($request->hasFile('background_image')) {
            $path = 'assets/uploads/background_images/' . $terminal->background_image;
            if (File::exists($path)) {
                File::delete($path);
            }
            $file = $request->file('background_image');
            $ext = $file->getClientOriginalExtension();
            $background_image_filename = time() . '.' . $ext;
            $file->move('assets/uploads/background_images', $background_image_filename);
        } else {
            $background_image_filename = $terminal->background_image;
        }
    
        if (array_key_exists('name', $input)) {
            $terminal->name = $input['name'];
        }
        if (array_key_exists('success_message', $input)) {
            $terminal->success_message = $input['success_message'];
        }
        if (array_key_exists('feedback_group_id', $input)) {
            $terminal->feedback_group_id = $input['feedback_group_id'];
        }
        if (array_key_exists('phone_number_required', $input)) {
            $terminal->phone_number_required = $input['phone_number_required'];
        }
        if (array_key_exists('email_required', $input)) {
            $terminal->email_required = $input['email_required'];
        }
        if (array_key_exists('sms_sender_id', $input)) {
            $terminal->sms_sender_id = $input['sms_sender_id'];
        }
        if (array_key_exists('notification_settings', $input)) {
            $terminal->notification_settings = $input['notification_settings'];
        }
        if (array_key_exists('customer_notification', $input)) {
            $terminal->customer_notification = $input['customer_notification'];
        }
    
        $terminal->background_image = $background_image_filename ?: $terminal->background_image;
        $terminal->terminal_logo = $terminal_logo_filename ?: $terminal->terminal_logo;
        $terminal->save();
    
        return $this->success(new TerminalResource($terminal), "Terminal updated successfully.");
    }

    public function destroy($id)
    {
    
        $terminal =Terminal::find($id);
        if ($terminal->terminal_logo) {
        $path = 'assets/uploads/terminal_logos/'.$terminal->terminal_logo;
        if (File::exists($path)) {
         File::delete($path);
            }
           }
           if ($terminal->background_image) {
            $path = 'assets/uploads/background_images/'.$terminal->background_image;
            if (File::exists($path)) {
             File::delete($path);
                }
               }
        $terminal->delete();
        return $this->success([], 'Terminal deleted successfully.');
    }

}
