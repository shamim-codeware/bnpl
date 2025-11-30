<?php

namespace App\Http\Controllers;

use App\Models\ErpLog;
use App\Service\ApiService;
use App\Models\HirePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErpController extends Controller
{
    public function ErpView($id){
        $title = "Enquiry Type";
        $description = "Some description for the page";
        $ErpLog  = ErpLog::with(['order'])->findOrFail($id);
        $data['customer_info'] = json_decode($ErpLog->cus_info);
        $data['order_info']    = json_decode($ErpLog->order_info);

        $data['order_details'] = json_decode($ErpLog->order_details);
        $data['response']      = json_decode($ErpLog->response);
        $data['order']         = $ErpLog->order;
        $data['id']            = $ErpLog->id;
        $data['title']         = $title;
        $data['description']   = $description;
        return view('installment.hire_purchase.erp_log',$data);
    }

    public function ResendErp(Request $request,ApiService $ApiService){
        // $customerInfo = array_filter([
        //     "name" => $request->input('name'),
        //     "mobile" => $request->input('mobile'),
        //     "email" => $request->input('email'),
        //     "address" => $request->input('address'),
        //     "city" => $request->input("city"), // Assuming $district is set elsewhere
        //     "date_of_birth" => $request->input('date_of_birth'),
        //     "designation" => $request->input('designation'),
        //     "profession" => $request->input('profession'),
        //     "org" => $request->input('org')
        // ]);

        $customerInfo = [
            "name"         => $request->input('name'),
            "mobile"       => $request->input('mobile'),
            "email"        => $request->input('email'),
            "address"      => trim($request->input('address') ?? ''), // always string
            "city"         => $request->input("city"),
            "date_of_birth" => $request->input('date_of_birth'),
            "designation"  => $request->input('designation'),
            "profession"   => $request->input('profession'),
            "org"          => $request->input('org')
        ];

        // Prepare order information
        $orderInfo = array_filter([
            "eorder_no" => $request->input('eorder_no'),
            "entry_date" => now()->toDateTimeString(),
            "down_payment" => $request->input('down_payment'),
            "instalments_rate" =>$request->input('instalments_rate'),
            "no_instalments" => (int)$request->input('no_instalments'),
            "sales_from" => $request->input('sales_from'),
            "delivery_from" => $request->input('delivery_from'),
            "delivery_fee" => 0, // Assuming no delivery fee is applied
            "note" => $request->input('note'),
            'payment_ref'=>"Cash"
        ]);

        // Prepare order details
        $orderDetails = [
            [
                "item_model" => $request->input('item_model'),
                "item_qty" => (int)$request->input('item_qty', 1), // Default to 1 if not provided
                "unit_rate" => $request->input('unit_rate'),
                "unit_wise_disc" => (int)$request->input('unit_wise_disc', 0)
            ]
        ];
        $customerJsonInfo = json_encode($customerInfo);
        $orderJsonDetails = json_encode($orderDetails);
        $orderJsonInfo = json_encode($orderInfo);
        $erp_log = ErpLog::findOrFail($request->id);

        $erpLogData = [
            'cus_info'      =>$customerJsonInfo,
            'order_details' =>$orderJsonDetails,
            'order_info'    =>$orderJsonInfo,
            'retry'         => $erp_log->retry + 1,
        ];

        $erp_log->fill($erpLogData)->save();
        $requestData = [
            "update_flag" => 0,
            "cancel_flag" => 0,
            "cus_info" => json_decode($erp_log->cus_info),
            "order_info" => json_decode($erp_log->order_info),
            "order_details" => json_decode($erp_log->order_details)
        ];

     $response =    $ApiService->SendToErp($requestData);
     if($response['error'] == 1){
        $erp_log->sent = 0;
    }else{
       $erp_log->sent = 1;
    }
    $erp_log->response = $response;
    $erp_log->save();

    if($response['error'] == 1){
        return redirect()->back()->with('error', 'Erp Order Create Not Successfull ! Please Try Again');
    }else{
        return redirect()->back()->with('success', 'Erp Product Create Successfull !');
    }
        // return $erpLogData;
    }

    public function SaleCancel($id){
        $hirepurchases = HirePurchase::findOrFail($id);
        $title  = "Sale Cancel";
        $description = "Some description for the page";
        $ErpLog  = ErpLog::with(['order'])->findOrFail(@$hirepurchases->erplog->id);
        $data['customer_info'] = json_decode($ErpLog->cus_info);
        $data['order_info']    = json_decode($ErpLog->order_info);
        $data['order_details'] = json_decode($ErpLog->order_details);
        $data['response']      = json_decode($ErpLog->response);
        $data['order']         = $ErpLog->order;
        $data['id']            = $ErpLog->id;
        $data['title']         = $title;
        $data['description']   = $description;

        return view('installment.hire_purchase.sale_cancel',$data);
    }

    public function CancelAction(Request $request,$id,ApiService $ApiService)
    {
        $erp_log = ErpLog::findOrFail($id);
        $requestData = [
            "update_flag" => 0,
            "cancel_flag" => 1,
            "cus_info" => json_decode($erp_log->cus_info, true),
            "order_info" => json_decode($erp_log->order_info, true),
            "order_details" => json_decode($erp_log->order_details, true)
        ];
        $erp_log->cancel_flag = 1;

        $response = $ApiService->SendToErp($requestData);
        Log::info('ERP Response', ['response' => $response]);

        if (@$response['error'] == 1) {
            $erp_log->sent = 0;
        } else {
            $erp_log->sent = 1;
        }

        $erp_log->response = $response;

        $erp_log->save();

        $hirePurchase = HirePurchase::where('id',$erp_log->tracking_number)->first();
        if ($hirePurchase) {
            $hirePurchase->status = 4; // Assuming 4 is the status for cancelled
            $hirePurchase->save();
        }
        return redirect()->back()->with('success', 'Erp Order Cancel Successfull !');

    }



  public function UnsendErpList() {
        $title = "Unsent ERP List";
        $description = "List of BNPL orders that need to be sent to ERP";

        $hirePurchases = HirePurchase::with([
            'purchase_products.product_category',
            'purchase_products.brand',
            'purchase_products.product',
            'show_room',
            'show_room_user',
            'erplog'
        ])
        ->where('status', 3) // Confirmed sales
        ->where('order_no', 'like', 'BNPL%')
        ->whereHas('erplog', function($query) {
            $query->where('sent', 0);
        })
        ->latest()
        ->get();

        return view('installment.hire_purchase.unsend_erp_list', compact('title', 'description', 'hirePurchases'));
    }


}
