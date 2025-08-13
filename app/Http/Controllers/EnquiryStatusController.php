<?php

namespace App\Http\Controllers;

use App\Models\EnqueryStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helper;
use App\Models\Setting;

class EnquiryStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title           = "Enquiry Status";
        $description     = "Some description for the page"; 
        $status_types    = Helper::status_types();

        $status = EnqueryStatus::where('parent_id',0)->orderBy('id','DESC')->get();
        // Query
        $query = EnqueryStatus::with('users');
        // Keyword
        if($request->keyword){
            $query->where('name', 'like', "%$request->keyword%");
        }
        $enquiry_status = $query->orderBy('id','DESC')->paginate(30);
        return view('pages.settings.enqu_status.index', compact('title', 'description','enquiry_status','status_types', 'status'));
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $data = $request->all();
        $data['created_by'] = Auth::user()->id;
        // Status 
        $status = new EnqueryStatus();
        $status->fill($data)->save();

        return  redirect()->back()->with('success', 'Success! Create Enquiry Status');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $enquiry_status = EnqueryStatus::findOrFail($id);
        if($enquiry_status->status == 1){
            $enquiry_status->status = 0;
        }else{
            $enquiry_status->status = 1;
        }
        $enquiry_status->save();

        return  redirect()->back()->with('success', 'Success! Enquiry Status Change ');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $title = "Enquiry Status";
        $description = "Some description for the page";
        $enquirySource = EnqueryStatus::with('parents')->findOrFail($id);
        $status = EnqueryStatus::where('parent_id', 0)->orderBy('id', 'DESC')->get();
        $enquiryparents = EnqueryStatus::orderBy('id','DESC')->get();
        return view('pages.settings.enqu_status.edit', compact('title', 'description','enquirySource','enquiryparents', 'status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $enquiry_status = EnqueryStatus::findOrFail($id);
        $enquiry_status->fill($request->all())->save();

        return  redirect('enquiry-status')->with('success', 'Success! Create Enquiry Status');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
 
    public function statusSetting()
    {    
        $title          = "Enquiry Status";
        $description    = "Some description for the page";
        $enquiry_status = EnqueryStatus::orderBy('id','DESC')->get();
        $parent_assign  = @Setting::first()->enquiry_status;

        return view('pages.settings.enqu_status.enquiry_setting', compact('title', 'description','enquiry_status', 'parent_assign'));
    }
    public function parentAssign(Request $request)
    {    
         $validator = Validator::make($request->all(), [
            'open'  => 'required|numeric',
            'sale'  => 'required|numeric',
            'close' => 'required|array', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }
        else{
            if(!in_array($request->input('sale'), $request->input('close'))){
                return response()->json(['errors' => ['Sale must be assigned to close.']], 401);
            }
            // Setting
            $setting = Setting::first();
            if(empty($setting)){
                $setting = new Setting();
            }  
            $enquiry_status = [
                'open'  => $request->input('open'),  // 1
                'close' => $request->input('close'), // 2
                'sale'  => $request->input('sale'),  // 3
                'pending'=>$request->input('pending'),//4
            ];
            // Status update
            $setting->enquiry_status = $enquiry_status;
            $setting->save();
            
            return response()->json(['status' => 1, 'message' => 'Success! Save'], 200);
        }
    }
}
