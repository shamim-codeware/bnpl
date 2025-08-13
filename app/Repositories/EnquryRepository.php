<?php

namespace App\Repositories;


use App\Repositories\EnquiryInterface as EnquiryInterface;
use App\Models\Enquery;
use App\Models\Customer;
use App\Models\EnquiryProduct;
use App\Models\FollowUp;
use App\Models\Setting;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class EnquryRepository implements EnquiryInterface
{
    public $enquery;
    function __construct(Enquery $enquery)
    {
        $this->enquery = $enquery;
    }
    public function enquiry($data)
    {

        date_default_timezone_set('Asia/Dhaka');

        if (!empty($data['type_of_offer'])) {
            $type_offer =  json_encode($data['type_of_offer']);
        } else {
            $type_offer = '';
        }

        $notification = [];

        $enquery = new Enquery;
        if (Auth::user()->role_id == 1) {
            // $data['assign'] = $data['assign'];
            $data['showroom_id'] = $data['showroom_id'];
            $notification['showroom_id'] = $data['showroom_id'];
        } elseif (Auth::user()->role_id == 2) {
            $data['assign'] = Auth::user()->id;
            $data['showroom_id'] = Auth::user()->showroom_id;
            $notification['showroom_id'] = Auth::user()->showroom_id;
        } elseif (Auth::user()->role_id == 3) {
            //$data['assign'] = Auth::user()->id;
            $data['showroom_id'] = Auth::user()->showroom_id;
            $notification['showroom_id'] = Auth::user()->showroom_id;
        }
        $data['created_by'] = Auth::user()->id;
        $data['type_of_offer'] = $type_offer;
        //dd($data);
        $enquery->fill($data)->save();


        // if((Auth::user()->role_id == 1) || (Auth::user()->role_id == 3)){

        $notification['name'] = $data['name'];
        $notification['next_follow_up_date'] = $data['next_follow_up_date'];
        $notification['enquiry_id'] = $enquery->id;
        $notification['customer_id'] = $data['customer_id'];
        $notification['assign']    = $data['assign'];
        $notification['created_by'] = Auth::user()->id;
        $notification['notifications_type'] = 1;

        $notifi = new Notification;
        $notifi->fill($notification)->save();
        //  }

        return $enquery->id;
    }


    public function customer($data)
    {
        $cus = new Customer;
        if (Auth::user()->role_id == 1) {
            // $data['assign'] = $data['assign'];
            $data['showroom_id'] = $data['showroom_id'];
        } else {
            $data['showroom_id'] = Auth::user()->showroom_id;
        }


        $data['created_by'] = Auth::user()->id;
        $cus->fill($data)->save();

        return $cus->id;
    }

    public function product($data)
    {

        $product = new EnquiryProduct;
        $poductdata = [];
        foreach ($data['group_name'] as  $key => $group) {
            $poductdata['enquiry_id'] = $data['enquiry_id'];
            $poductdata['group_name'] = $data["group_name"][$key];
            $poductdata['category_name'] = $data['category_name'][$key];
            $poductdata['product_name'] = $data['product_name'][$key];
            $poductdata['group_id'] = $data["group_id"][$key];
            $poductdata['category_id'] = $data['category_id'][$key];
            $poductdata['product_id'] = $data['product_id'][$key];
            $poductdata['nw'] = 1;
            //$product->fill($poductdata)->save();
            EnquiryProduct::create($poductdata);
        }
        return 1;
    }

    public function followup($data)
    {
        $followup = new FollowUp;
        $enquiry_status = @Setting::first()->enquiry_status;
        $data[] = $enquiry_status['open'];

        $followup->fill($data)->save();
        return 1;
    }
}
