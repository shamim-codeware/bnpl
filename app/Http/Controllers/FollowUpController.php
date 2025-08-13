<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\EnqueryStatus;
use App\Models\FollowUpMethod;
use Illuminate\Http\Request;
use App\Models\FollowUp;
use App\Models\Setting;
use App\Models\Enquery; 
use App\Helpers\Helper;
use Illuminate\Support\Arr;

class FollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "quotations";
        $description = "Some description for the page";
        $follow_ups = FollowUp::orderBy('id','DESC')->get();
        return view('pages.follow-up.index', compact('title', 'description','follow_ups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $title            = Helper::formatOrdinal(FollowUp::where('enquiry_id',$id)->count())." Follow Up Attend";
        $description      = "Some description for the page";
        $enquiry          = Enquery::where('id',$id)->first();
        $followup         = FollowUp::with(['followupmethod','enquiry','enquiryparent','enquirychild'])->where('enquiry_id',$id)->orderBy('id','DESC')->first();

        $enquiry_parent_status   = EnqueryStatus::where('parent_id',0)->where('status', 1)->orderBy('id', 'DESC')->get();
    
        $enquiry_status   = EnqueryStatus::selectRaw('id, name')->where('status', 1)->orderBy('id','DESC')->get();
        $followup_methods = FollowUpMethod::where('id','!=',$followup->next_follow_up_method)->orderBy('id','DESC')->get();
        $settings = @Setting::first()->enquiry_status;
       
        // $status_pending = EnqueryStatus::whereIn('id',$settings['pending'])->get();
        // $status_close = EnqueryStatus::whereIn('id', $settings['close'])->where('id','!=',$settings['sale'])->get();
        // $status_open = EnqueryStatus::where('id',$settings['open'])->first();
        // $status_sale = EnqueryStatus::where('id', $settings['sale'])->first();


        $parent_settings = Helper::status_types();
       
      //  $html = view('ajaxview.attend_followup', compact('followup','enquiry_status','followup_methods','enquiry','settings'))->render();

      return view('pages.follow-up.edit',compact('title','description','parent_settings','followup','enquiry_status','followup_methods','enquiry','settings', 'enquiry_parent_status'));
        // Response 
       // return response()->json(['html' => $html, 'title' => $title , 'description' => $description]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
    }

    public function ChildStatus(Request $request){
        return EnqueryStatus::where('parent_id',$request->parent_id)->where('status',1)->orderBy('id','DESC')->get();
    }

    public function StatusCheck(Request $request){
        $settings = @Setting::first()->enquiry_status;

        $new_close_status = array_diff($settings['close'], [$settings['sale']]);
    
        $html = '';
     if(in_array($request->parent_status, $new_close_status)){
           $status =  EnqueryStatus::whereIn('id', $new_close_status)->where('parent_id','!=',0)->get();

            $html .= '
                        <div class="mb-25 select-style2">
                                <div class="dm-select ">
                                    <select required id="status_parent" name="status_child" class="form-control ">
                                    <option  value="">Select Purpose</option>';
            foreach ($status as $close) {
                $html .= '<option value="' . $close->id . '">' . $close->name . '</option>';
            }
            $html .= '</select>
                            </div>
                        </div>';

            return $html;

        }elseif(in_array($request->parent_status, $settings['pending'])){
            $status =  EnqueryStatus::whereIn('id', $settings['pending'])->where('parent_id','!=',0)->get();
     
            $html .= '<div class="mb-25 select-style2">
                                <div class="dm-select ">
                                     <select required id="status_parent" name="status_child" class="form-control ">
                                    <option value="">Select Purpose</option>';
            foreach ($status as $close) {
                $html .= '<option value="' . $close->id . '">' . $close->name . '</option>';
            }
            $html .= '</select>
                            </div>
                        </div>';

            return $html;
        }

      
       
      //EnqueryStatus::where('parent_id', $request->parent_id)->where('status', 1)->orderBy('id', 'DESC')->get();

      
    }



    public function CheckStatusAll(Request $request)
    {
        $settings = @Setting::first()->enquiry_status;

        $new_close_status = array_diff($settings['close'], [$settings['sale']]);

        $html = '';
        if (in_array($request->parent_status, $new_close_status)) {
            $status =  EnqueryStatus::whereIn('id', $new_close_status)->where('parent_id', '!=', 0)->get();

            $html .= '
                        <div class="mb-25 select-style2">
                                <div class="dm-select ">
                                    <select required id="status_parent" name="status_child" class="form-control ">
                                    <option  value="">All Purpose</option>';
            foreach ($status as $close) {
                $html .= '<option value="' . $close->id . '">' . $close->name . '</option>';
            }
            $html .= '</select>
                            </div>
                        </div>';

            return $html;
        } elseif (in_array($request->parent_status, $settings['pending'])) {
            $status =  EnqueryStatus::whereIn('id', $settings['pending'])->where('parent_id', '!=', 0)->get();

            $html .= '<div class="mb-25 select-style2">
                                <div class="dm-select ">
                                     <select required id="status_parent" name="status_child" class="form-control ">
                                    <option value="">All Purpose</option>';
            foreach ($status as $close) {
                $html .= '<option value="' . $close->id . '">' . $close->name . '</option>';
            }
            $html .= '</select>
                            </div>
                        </div>';

            return $html;
        } else {
            $html .= '<select id="status_parent" required  class="form-control ">
                    <option  value="">All Purpose</option>
                    </select>';

            return $html;
        }



        //EnqueryStatus::where('parent_id', $request->parent_id)->where('status', 1)->orderBy('id', 'DESC')->get();


    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'last_attend_date' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', 'Last Attend Date is required');
        }

       
        $enquiry_status = @Setting::first()->enquiry_status;
        $follow_up_date = date('Y-m-d H:i:s', strtotime($request->next_follow_up_date));
        $attend_date = date('Y-m-d H:i:s', strtotime($request->last_attend_date));
       
        // Status open check  
        if(($request->status_parent_ == @$enquiry_status['open']) AND ($request->next_follow_up_date == null)){
            $validator = Validator::make($request->all(), [
                'next_follow_up_date' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Next followup date is required');
            }
        }else{

            if((@$enquiry_status['open'] == $request->status_parent_) OR (in_array($request->status_parent_, @$enquiry_status['pending'])) ){

                $validator = Validator::make($request->all(), [
                    'next_follow_up_date' => 'required',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', 'Next followup date is required');
                }

            $followup_update =  Arr::except($request->all(), ['name', 'next_follow_up_method','next_follow_up_date']);
            $followup_update['last_attend_date'] =  $attend_date;
            $followup_update['status'] = 1;
            // Previous followup update 
       
            $followup = FollowUp::findOrFail($id);
            $followup->fill($followup_update)->save();
                // 
                // if($request->status_parent == @$enquiry_status['open']){
                //     $status_parent = 1;
                // }else if($request->status_parent == @$enquiry_status['close']){
                //     $status_parent = 2;
                // }else{
                //     $status_parent = 3;
                // }

                $status_parent = $request->status_parent_;

                if(@$enquiry_status['open'] == $request->status_parent_){
                    $status_child = $request->status_parent_; 
                }else{
                    $status_child = $request->status_child; 
                }
               
            // New followup
            $newData = $request->only(['name','next_follow_up_method','status_child','parent_status']);
           
            $newData['enquiry_id']    = $followup->enquiry_id;
            $newData['event_code']    = $followup->event_code;
            $newData['status_parent'] = $status_parent;
            $newData['status_child']  = $status_child;
            $newData['next_follow_up_date']  = $follow_up_date;
            $new_followup = new  FollowUp;
            $new_followup->fill($newData)->save();
            // Enquiry update
            $enquiry_update = $request->only(['last_attend_date']);
            $enquiry_update['next_follow_up_date'] = $follow_up_date;
            $enquiry_update['enquiry_status'] = $status_child; 
            $enquiry_update['parent_status'] =  $status_parent;
            $enquiry_update['last_attend_date'] = $attend_date;

            $enquiry = Enquery::where('id', $followup->enquiry_id)->first();
            $enquiry->fill($enquiry_update)->save();
        }else{

            $followup_update =  Arr::except($request->all(), ['name', 'next_follow_up_method', 'next_follow_up_date']);

                if (@$enquiry_status['sale'] == $request->status_parent_) {
                    $status_child = $request->status_parent_;
                } else {
                    $status_child = $request->status_child;
                }

            $followup_update['last_attend_date'] =  $attend_date;
            $followup_update['status'] = 1;

                $status_parent = $request->status_parent_;
                $followup_update['status_parent'] = $status_parent;
                $followup_update['status_child']  = $status_child;
            // Previous followup update 
            $followup = FollowUp::findOrFail($id);
            $followup->fill($followup_update)->save();

                $enquiry_update['enquiry_status'] = $status_child;
                $enquiry_update['parent_status'] =  $status_parent;

            $enquiry = Enquery::where('id', $followup->enquiry_id)->first();
            $enquiry->fill($enquiry_update)->save();
            
        }

            return redirect('enquiry')->with('success', 'Success! Update Follow-Up');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
