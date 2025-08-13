<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\EnquiryInterface as EnquiryInterface;
use App\Models\CustomerType;
use App\Models\EnquiryType;
use App\Models\EnquirySource;
use App\Models\PurchaseMode;
use App\Models\FollowUpMethod;
use App\Models\EnqueryStatus;
use App\Models\Customer;
use App\Models\ShowRoom;
use App\Models\Enquery;
use App\Models\Setting;
use Illuminate\Support\Arr;
use App\Models\User;
use App\Models\Zone;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerProfession;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EnquiryExport;
use App\Exports\ExportPending;
use App\Models\SourcePermission;
use DB;

class EnqueryController extends Controller
{
    public $enquiry;

    public $filterdata;


    public function __construct(EnquiryInterface $enquiry)
    {
        $this->enquiry = $enquiry;
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title']       = "Enquiry";
        $data['description'] = "Some description for the page";
        $data['zones']       = Zone::selectRaw('id, name')->where('status', 1)->get();
        $data['showrooms']   = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        $permissionsource = SourcePermission::where('role_id', Auth::user()->role_id)->pluck('source_id')->toArray();
        $data['sources']     = EnquirySource::selectRaw('id, name')->where('status', 1)->where('parent_id', 0)->get();
        $data['executives']   = User::where('role_id', 2)->where('showroom_id', Auth::user()->showroom_id)->orderBy('name', "ASC")->where('status', 1)->get();
        $data['status_types'] = Helper::status_types();
        $data['status'] = EnqueryStatus::orderBy('id', 'DESC')->where('status', 1)->get();
        $data['status_parent'] = EnqueryStatus::where('parent_id', 0)->orderBy('id', 'DESC')->where('status', 1)->get();
        //dd($data);
        return view('pages.enquiry.index', compact('data'));
    }
    public function passedOver()
    {
        $data['title']       = "Enquiry";
        $data['description'] = "Some description for the page";
        $data['zones']       = Zone::selectRaw('id, name')->where('status', 1)->get();
        $data['showrooms']   = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        $data['sources']     = EnquirySource::selectRaw('id, name')->where('status', 1)->where('parent_id', 0)->get();
        $data['status_types'] = Helper::status_types();
        //dd($data);
        return view('pages.enquiry.passedover', compact('data'));
    }

    public function enquiries(Request $request)
    {

        date_default_timezone_set('Asia/Dhaka');
        $enquiry_status = @Setting::first()->enquiry_status;
        $query = Enquery::with(['enquiry_type', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom', 'customer', 'customer.customer_types', 'enquirystatus', 'assign_by']);
        // Role Check 
        if (Auth::user()->role_id == 2) {
            $query->where('assign', Auth::user()->id);
        } else if (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        }else if((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)){
            $query->where('created_by', Auth::user()->id);
        }
        // Filter 
        if ($request->from_date && $request->to_date) {
            // Date query
            if ($f_date_format = $request->from == 'today') {
                $query->whereHas('follow_ups', function ($enquiry) {
                    $enquiry->where('status', 0);
                });
                $from_date = date('Y-m-d H:i:00');
            } else {
                $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            }
            $db_column  = $request->date_type == 1 ? 'next_follow_up_date' : 'created_at';
            $to_date    = date('Y-m-d 23:59:59', strtotime($request->to_date));
            // Date     
            $query->whereBetween($db_column,  [$from_date, $to_date]);
        } else {
            $from_date = date('Y-m-1 00:00:00');
            $to_date   = date('Y-m-t 23:59:59');
            // Date 
            $query->whereBetween('next_follow_up_date',  [$from_date, $to_date]);
        }
        if ((Auth::user()->role_id == 1) || (Auth::user()->role_id == 6)|| (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8) || (Auth::user()->role_id == 9)) {
            if ($request->zone_id) {
                $zone_id = $request->zone_id;
                // Zone 
                $query->whereHas('showroom', function ($q) use ($zone_id) {
                    $q->where('zone_id', $zone_id);
                });
            }
            if ($request->showroom_id) {
                $query->where('showroom_id', $request->showroom_id);
            }
        }
        if ($request->source_id) {
            $query->where('source_parent', $request->source_id);
        }
        if ($request->buying_aspect) {
            $query->where('buying_aspect', $request->buying_aspect);
        }

        if ($request->status) {
            $query->where('parent_status', $request->status);
        }
        $new_close_status = array_diff($enquiry_status['close'], [$enquiry_status['sale']]);
        if ($request->status_from_dashboard) {
            if ($request->status_from_dashboard == 'close') {
                $query->whereIn('enquiry_status', $new_close_status);
            } else {
                $query->whereIn('enquiry_status', $enquiry_status[$request->status_from_dashboard]);
            }
        }
        if ($request->executive_id) {
            $query->where('assign', $request->executive_id);
        }

        if ($request->status_child) {

            $query->where('enquiry_status', $request->status_child);
        }



        // if($request->from == 'today'){
        //     $query->where('status',0)->where('next_follow_up_date', '>', now()->format('Y-m-d H:i:00'));

        // }

        // Status type
        // if($request->status_type && $enquiry_status){ 
        //     if($request->status_type == 1){ // Open == 1
        //         $query->where('enquiry_status', $enquiry_status['open']);    
        //     }
        //     else if($request->status_type == 2){  // Close == 2
        //         $query->where('enquiry_status', $enquiry_status['close']);
        //     }
        //     else{ // Sale == 3
        //         $query->where('enquiry_status', $enquiry_status['sale']);
        //     }
        // } 

        $enquiries = $query->orderBy('id', 'DESC')->paginate(30);

        // $this->filterdata =  $enquiries;
        $total = $query->count();

        return view('ajaxview.enquiries', compact('enquiries', 'enquiry_status', 'total'));
    }

    public function export(Request $request)
    {

        $query = Enquery::with(['enquiry_type', 'purchase_modes', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom', 'customer.customer_types', 'enquirystatus', 'assign_by']);
        // Role Check 
        if (Auth::user()->role_id == 2) {
            $query->where('assign', Auth::user()->id);
        } else if (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        }else if ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {
            $query->where('created_by', Auth::user()->id);
        }
        // Filter 
        if ($request->from_date && $request->to_date) {
            $column    = $request->date_type == 1 ? 'next_follow_up_date' : 'created_at';
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date   = date('Y-m-d 23:59:59', strtotime($request->to_date));
            // Date 
            $query->whereBetween($column,  [$from_date, $to_date]);
        } else {
            $from_date = date('Y-m-1 00:00:00');
            $to_date   = date('Y-m-t 23:59:59');
            // Date 
            $query->whereBetween('next_follow_up_date',  [$from_date, $to_date]);
        }
        if ((Auth::user()->role_id == 1)|| (Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {
            if ($request->zone_id) {
                $zone_id = $request->zone_id;
                // Zone 
                $query->whereHas('showroom', function ($q) use ($zone_id) {
                    $q->where('zone_id', $zone_id);
                });
            }
            if ($request->showroom_id) {
                $query->where('showroom_id', $request->showroom_id);
            }
        }
        if ($request->source_id) {
            $query->where('source_parent', $request->source_id);
        }
        if ($request->buying_aspect) {
            $query->where('buying_aspect', $request->buying_aspect);
        }

        if ($request->status) {
            $query->where('enquiry_status', $request->status);
        }

        if ($request->executive_id) {
            $query->where('assign', $request->executive_id);
        }

        $enquiry_status = @Setting::first()->enquiry_status;
        // Status type
        // if($request->status_type && $enquiry_status){ 
        //     if($request->status_type == 1){ // Open == 1
        //         $query->where('enquiry_status', $enquiry_status['open']);    
        //     }
        //     else if($request->status_type == 2){  // Close == 2
        //         $query->where('enquiry_status', $enquiry_status['close']);
        //     }
        //     else{ // Sale == 3
        //         $query->where('enquiry_status', $enquiry_status['sale']);
        //     }
        // } 

        $enquiries = $query->orderBy('id', 'DESC')->get();
        //dd($enquiries);
        return Excel::download(new EnquiryExport($enquiries), 'enquiry-report.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Enquiry";
        $description = "Some description for the page";
        $customer_types = CustomerType::orderBy('id', 'DESC')->where('status', 1)->get();
        if (Auth::user()->role_id == 3) {
            $executives = User::where('role_id', 2)->where('status', 1)->where('showroom_id', Auth::user()->showroom_id)->get();
        } else {
            $executives = User::where('role_id', 2)->where('status', 1)->get();
        }

        $districts = DB::table('districts')->orderBy('id', 'DESC')->where('status', 1)->get();
        $enquery_types = EnquiryType::orderBy('id', 'DESC')->where('status', 1)->get();
        $showrooms = ShowRoom::orderBy('id', 'DESC')->where('status', 1)->get();
         $permissionsource = SourcePermission::where('role_id', Auth::user()->role_id)->pluck('source_id')->toArray();
        $sources_awerness = EnquirySource::orderBy('priority', 'ASC')->where('status', 1)->where('parent_id', 0)->whereIn('id', $permissionsource)->get();
        $purchasemods = PurchaseMode::orderBy('id', 'DESC')->where('status', 1)->get();
        $methods = FollowUpMethod::orderBy('id', 'DESC')->where('status', 1)->get();
        $customers_professions = CustomerProfession::orderBy('id', 'DESC')->where('status', 1)->get();
      
        return view('pages.enquiry.enquiry', compact('title','description', 'customer_types', 'sources_awerness', 'purchasemods', 'enquery_types', 'methods', 'showrooms', 'executives', 'customers_professions', 'districts'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->all());

        $request->validate([
            'next_follow_up_date' => 'required',
        ]);

        date_default_timezone_set('Asia/Dhaka');

        DB::beginTransaction();

        try {
            $last = Enquery::orderBy('id', 'DESC')->first();
            if (empty($last)) {
                $next_id = 1;
            } else {
                $next_id = $last->id + 1;
            }
            $event_code     = 'REM0000' . $next_id;
            $requestData    = $request->all();
            $open_status    = @Setting::first()->enquiry_status['open'];
            $follow_up_date = date('Y-m-d H:i:s', strtotime($request->next_follow_up_date));
            $sales_date     = date('Y-m-d', strtotime($request->sales_date));
            $enquiryData    = Arr::except($requestData, ['alt_number', 'email', 'profession', 'gender', 'type_id', 'product_name', 'category_name', 'group_name']);
            // Customer check 
            $check  = Customer::where('number', $request->number)->get();
            if (count($check) <= 0) {
                $for_customer = $request->only(['age', 'district_id', 'upazila_id', 'name', 'showroom_id', 'number', 'alt_number', 'email', 'profession', 'gender', 'type_id']);
                $customer_id  = $this->enquiry->customer($for_customer);
            } else {
                $customer_id = $check[0]->id;
            }
            $enquiryData['customer_id']    = $customer_id;
            $enquiryData['event_code']     = $event_code;
            $enquiryData['enquiry_status'] = $open_status;
            $enquiryData['sales_date']     = $sales_date;
            $enquiryData['next_follow_up_date'] = $follow_up_date;
            $enquiry_id = $this->enquiry->enquiry($enquiryData);
            // Product entry
            $productData = $request->only(['group_name', 'category_name', 'product_name', 'group_id', 'category_id', 'product_id']);
            $productData['enquiry_id'] = $enquiry_id;
            $product_id = $this->enquiry->product($productData);
            // Followup entry 
            $followupData                  = $request->only(['next_follow_up_method', 'name']);
            $followupData['next_follow_up_date'] = $follow_up_date;
            $followupData['enquiry_id']    = $enquiry_id;
            $followupData['event_code']    = $event_code;
            $followupData['status_parent'] = 1;
            $followupData['status_child']  = $open_status;
            $follow_up_id = $this->enquiry->followup($followupData);

            DB::commit();

            return  redirect()->back()->with('success', 'Success! An enquiry has been created');
        } catch (\Throwable $e) {
            DB::rollback();
            // throw $e;
            return  redirect()->back()->with('error', 'Something want wrong ! Please Try Again');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $title = "Enquiry History";
        $description = "Some description for the page";
        $enquiries = Enquery::with(['enquiry_type', 'customer.customer_types', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom'])
            ->where('id', $id)->first();
        //dd($enquiries);
        $html = view('ajaxview.history', compact('title', 'description', 'enquiries'))->render();
        // Response 
        return response()->json(['html' => $html, 'title' => $title, 'description' => $description]);
    }

    public function statusType($type_id)
    {
        $close_status = @Setting::first()->enquiry_status['close'];
        if ($close_status) {
            return EnqueryStatus::selectRaw('id, name')->whereIn('id', $close_status)->get();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enquery $enquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enquery $enquiry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enquery $enquiry)
    {
        //
    }
    

    public function passedOverEnquiries(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $enquiry_status = @Setting::first()->enquiry_status;
        $query = Enquery::with(['enquiry_type', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom', 'customer', 'customer.customer_types', 'enquirystatus'])->where('next_follow_up_date', '<', now())->where('enquiry_status', $enquiry_status['open']);
        // Role Check 
        if (Auth::user()->role_id == 2) {
            $query->where('assign', Auth::user()->id);
        } else if (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);

        } else if ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {
            
            $query->where('created_by', Auth::user()->id);
        }
        // Filter 
        $enquiries = $query->orderBy('id', 'DESC')->paginate(30);
        $total = $query->count();
        return view('ajaxview.enquiries', compact('enquiries', 'enquiry_status', 'total'));
    }

    public function Pending(){

        $data['title']       = "Enquiry";
        $data['description'] = "Some description for the page";
        $data['zones']       = Zone::selectRaw('id, name')->where('status', 1)->get();
        $data['showrooms']   = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        $data['sources']     = EnquirySource::selectRaw('id, name')->where('status', 1)->where('parent_id', 0)->get();
        $data['status_types'] = Helper::status_types();
        //dd($data);
        return view('pages.enquiry.pending-enquiry', compact('data'));

    }

    public function PendingEnquiry(Request $request ){

        date_default_timezone_set('Asia/Dhaka');
        $enquiry_status = @Setting::first()->enquiry_status;
        $query = Enquery::with(['enquiry_type', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom', 'customer', 'customer.customer_types', 'enquirystatus'])->whereIn('enquiry_status', $enquiry_status['pending']);
        // Role Check 
        if (Auth::user()->role_id == 2) {
            $query->where('assign', Auth::user()->id);
        } else if (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } else if ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {

            $query->where('created_by', Auth::user()->id);
        }
        // Filter 
        $total = $query->count();
        $enquiries = $query->orderBy('id', 'DESC')->paginate(30);
      
        return view('ajaxview.pending-enquiry', compact('enquiries', 'enquiry_status', 'total'));

    }

    public function Passedexport(Request $request)
    {
        $enquiry_status = @Setting::first()->enquiry_status;

        $query = Enquery::with(['enquiry_type', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom', 'customer', 'customer.customer_types', 'enquirystatus'])->where('next_follow_up_date', '<', now())->where('enquiry_status', $enquiry_status['open']);
        // Role Check 
        if (Auth::user()->role_id == 2) {
            $query->where('assign', Auth::user()->id);
        } else if (Auth::user()->role_id == 3) {

            $query->where('showroom_id', Auth::user()->showroom_id);
        } else if ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {
            $query->where('created_by', Auth::user()->id);
        }
        // Filter 

        $enquiries = $query->orderBy('id', 'DESC')->get();


        return Excel::download(new EnquiryExport($enquiries), 'enquiry-passed-report.xlsx');
    }


    public function PendingEnquiryExport(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        $enquiry_status = @Setting::first()->enquiry_status;
        $query = Enquery::with(['enquiry_type', 'product', 'enquiry_source_child', 'customer', 'users', 'showroom', 'customer', 'customer.customer_types', 'enquirystatus'])->whereIn('enquiry_status', $enquiry_status['pending']);
        // Role Check 
        if (Auth::user()->role_id == 2) {
            $query->where('assign', Auth::user()->id);
        } else if (Auth::user()->role_id == 3) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } else if ((Auth::user()->role_id == 6) || (Auth::user()->role_id == 7) || (Auth::user()->role_id == 8)) {

            $query->where('created_by', Auth::user()->id);
        }
        // Filter 

        $enquiries = $query->orderBy('id', 'DESC')->get();


        return Excel::download(new ExportPending($enquiries), 'pending-enquiry-report.xlsx');
    }
}
