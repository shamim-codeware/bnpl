<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquery;
use DB;

class BackupController extends Controller
{
    public function DataBackup(){


        // $data = Enquery::where('source_child',14)->get();

        $data = DB::table('backupenquiry')->get();

      //  dd($data);

      //  $datas = '`id`, `customer_id`, `showroom_id`, `enquiry_type_id`, `event_code`, `name`, `number`, `source_parent`, `source_child`, `purchase_mode`, `sales_date`, `buying_aspect`, `offers`, `type_of_offer`, `next_follow_up_date`, `last_attend_date`, `assign`, `seen`, `enquiry_status`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`';


        foreach($data as $d){
        $insertData = [
            'id'=>$d->id,
            'customer_id'=>$d->customer_id,
                'showroom_id'=>$d->showroom_id,
                'enquiry_type_id'=>$d->enquiry_type_id,
                'event_code'=>$d->event_code,
                'name'=>$d->name,
                'number'=>$d->number,
                'source_parent'=>$d->source_parent,
                'purchase_mode'=>$d->purchase_mode,
                'sales_date'=>$d->sales_date,
                'buying_aspect'=>$d->buying_aspect,
                'offers' =>$d->offers,
                'type_of_offer'=>$d->type_of_offer,
                'next_follow_up_date'=>$d->next_follow_up_date,
                'last_attend_date'=>$d->last_attend_date,
                'assign'=>$d->assign,
                'seen'=>$d->seen,
                'enquiry_status'=>$d->enquiry_status,
                'status'   =>$d->status,
                'created_by'=>$d->created_by,
                'updated_by'=>$d->updated_by,
                'created_at'=>$d->created_at,
                'updated_at'=>$d->updated_at
        ];

       DB::table('enquiries')->insert($insertData);

    }

    }

    public function DataProductBackup(){

        $data = DB::table('enquiry_product_backup')->get();

        foreach($data as $products){
           // $products = DB::table('enquiry_products')->where('enquiry_id',$d->id)->first();

        //   dd($products);
//`id`, `enquiry_id`, `group_name`, `category_name`, `product_name`, `created_by`, `updated_by`, `created_at`, `updated_at`
             $insertData = [
            'id'=>$products->id,
                'enquiry_id'=> $products->enquiry_id,
                'group_name'=> $products->group_name,
                'category_name'=> $products->category_name,
                'product_name'=> $products->product_name,
                'created_by'=> $products->created_by,
                'updated_by'=> $products->updated_by,
                'created_at'=> $products->created_at,
                'updated_at'=> $products->updated_at
             ];

            DB::table('enquiry_products')->insert($insertData);
        }
    }
}
