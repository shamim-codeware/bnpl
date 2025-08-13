<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\EnquiryType;
use App\Models\EnquirySource;
use App\Models\PurchaseMode;
use App\Models\FollowUpMethod;
use App\Models\User;


class EnquiryController extends Controller
{
    public function index()
    {
        $title = "Enquiry";
        $description = "Some description for the page";
        $customer_types = CustomerType::orderBy('id','DESC')->get();
        $enquery_types = EnquiryType::orderBy('id','DESC')->get();

        $sources_awerness = EnquirySource::orderBy('id','DESC')->where('parent_id',0)->get();
        $purchasemods = PurchaseMode::orderBy('id','DESC')->get();
        $methods = FollowUpMethod::orderBy('id','DESC')->get();

        return view('pages.enquiry.enquiry', compact('title', 'description','customer_types','sources_awerness','purchasemods','enquery_types','methods'));
    }
   
    public function quotations()
    {
        $title = "quotations";
        $description = "Some description for the page";
        return view('pages.enquiry.quotations', compact('title', 'description'));
    }
    public function preBooking()
    {
        $title = "pre-booking";
        $description = "Some description for the page";
        return view('pages.enquiry.pre-booking', compact('title', 'description'));
    }

    public function store(Request $request){
       // dd($request->all());
        
        $customer = [];

         $check  = Customer::where('number',$request->number)->get();
       //  dd(count($check));
         if(count($check) <= 0){
        $customer['name'] = $request->name;
        $customer['number'] = $request->number;
        $customer['alt_number'] = $request->alt_number;
        $customer['email'] = $request->email;
        $customer['profession'] = $request->profession;
        $customer['gender'] = $request->gender;
        $customer['created_by'] = Auth::user()->id;
        $customer['customer_type'] = $request->customer_type;
      
        $cus = new Customer;
        $cus->fill($customer)->save();
         $customer_id = $cus->id;

         return redirect()->back();
         }else{

         }

         return redirect()->back();
    }

    public function CustomerEnquiry(Request $request){

        $customer = Customer::where('number',$request->number)->where('status',1)->first();
        return json_encode($customer);
    }

    public function SelectExecutive(Request $request){

        $executive = User::where('showroom_id',$request->parent_id)->where('status',1)->where('role_id',2)->get();
        return json_encode($executive);
    }

    public function SourcesOfAwreness(Request $request){
         
        $sources = EnquirySource::where('parent_id',$request->parent_id)->where('status',1)->get();
        return json_encode($sources);
    }

}
