<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bank;
use App\Models\User;
use App\Models\Zone;
use App\Models\Brand;
use App\Models\ErpLog;
use App\Models\Product;
use App\Models\Upazila;
use App\Models\Customer;
use App\Models\District;
use App\Models\ShowRoom;
use App\Models\Incentive;
use App\Models\Installment;
use App\Models\ProductType;
use App\Models\Transaction;
use App\Service\ApiService;
use App\Models\HirePurchase;
use App\Models\InterestRate;
use App\Models\Notification;
use App\Models\ShowRoomUser;
use Illuminate\Http\Request;
use App\Models\GuaranterInfo;
use App\Models\EnquiryProduct;
use App\Models\ZonePermission;
use App\Models\NotificationSeen;
use App\Models\CustomerProfession;
use App\Models\DownPaymentSetting;
use Illuminate\Support\Facades\DB;
use App\Models\HirePurchaseProduct;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\GeneralIncentiveConfig;
use App\Models\IncentiveConfiguration;
use App\Traits\LateFeeCalculationTrait;
use Illuminate\Support\Facades\Session;

class HirePurchaseController extends Controller
{
    use LateFeeCalculationTrait;


    public function apiMarge()
    {

        $showroom = ShowRoom::orderBy('name', 'asc')->get();

        $i = 0;
        foreach ($showroom as $showroom) {
            $shops = DB::table('shops')->where('ctp_name', 'LIKE', '%' . $showroom->name . '%')->first();
            echo "<br>";

            if (!empty($shops)) {
                $i += 1;
                echo $showroom->name . " =    " . $shops->ctp_name . "<br> <br>";
                $showroom->ctp_name = $shops->ctp_name;
                $showroom->save();
            }
            //            print_r($shops);
        }

        dd($i);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Hire Purchase";
        $description = "Some description for the page";

        $districts = DB::table('districts')->orderBy('id', 'DESC')->where('status', 1)->get();
        $product_type = ProductType::latest()->get();
        $brands = Brand::latest()->get();
        $customers_professions = CustomerProfession::orderBy('id', 'DESC')->where('status', 1)->get();
        $products = Product::latest()->get();
        $showrooms = ShowRoom::latest()->get();
        $banks = Bank::latest()->get();

        $showroom_credit = ShowRoom::where('id', auth()->user()->showroom_id)->first();
        $showroomusers = ShowRoomUser::where('showroom_id', Auth::user()->showroom_id)->latest()->get();
        $interestrate = InterestRate::latest()->get();
        $down_payment_parcentage = DownPaymentSetting::latest()->get();
        return view('installment.hire_purchase.application', compact(
            "title",
            'banks',
            "description",
            "customers_professions",
            "districts",
            "products",
            'showroomusers',
            'showrooms',
            "brands",
            "product_type",
            "interestrate",
            "showroom_credit",
            "down_payment_parcentage"
        ));
    }

    public function SalePending()
    {
        $title = "Hire Purchase";
        $description = "Some description for the page";
        if (Auth::user()->role_id == User::RETAIL) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $zones = Zone::selectRaw('id, name')->whereIn('id', $permission)->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->whereIn('zone_id', $permission)->where('status', 1)->get();
        } elseif (Auth::user()->role_id == User::ZONE) {
            $showrooms = ShowRoom::selectRaw('id, name')->where('zone_id', Auth::user()->zone_id)->where('status', 1)->get();
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
        } else {
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        }
        return view('installment.hire_purchase.salepending-index', compact("title", "description", "zones", "showrooms"));
    }

    public function PendingSale()
    {
        $title = "Hire Purchase";
        $description = "Some description for the page";
        if (Auth::user()->role_id == User::RETAIL) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $zones = Zone::selectRaw('id, name')->whereIn('id', $permission)->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->whereIn('zone_id', $permission)->where('status', 1)->get();
        } elseif (Auth::user()->role_id == User::ZONE) {
            $showrooms = ShowRoom::selectRaw('id, name')->where('zone_id', Auth::user()->zone_id)->where('status', 1)->get();
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
        } else {
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        }
        return view('installment.hire_purchase.pending-index', compact("title", "description", "zones", "showrooms"));
    }


    // public function Product_update(Request $request, $id)
    // {
    //     date_default_timezone_set('Asia/Dhaka');
    //     // Find the hire purchase product
    //     $hirePurchaseProduct = HirePurchaseProduct::where('hire_purchase_id', $id)->firstOrFail();
    //     $hirePurchase = HirePurchase::findOrFail($id);

    //     // Get the original values for comparison
    //     $originalHirePrice = $hirePurchaseProduct->hire_price;
    //     $originalDownPayment = $hirePurchaseProduct->down_payment;

    //     // Get the new values
    //     $hire_price = $request->hire_price;
    //     $down_payment = $request->down_payment;

    //     // Calculate due amounts
    //     $originalDue = $originalHirePrice - $originalDownPayment;
    //     $newDue = $hire_price - $down_payment;
    //     $additionalCreditNeeded = $newDue - $originalDue;

    //     // Check showroom credit limit
    //     $showroom = ShowRoom::findOrFail($hirePurchase->showroom_id);
    //     $availableCredit = $showroom->remaining_credit + $originalDue;

    //     if ($additionalCreditNeeded > $availableCredit) {
    //         return redirect()->back()->with('error', 'You have exceeded your credit limitation. Your current available credit is ' . $availableCredit);
    //     }
    //     DB::beginTransaction();
    //     //        try {
    //     // Update hire purchase product
    //     $hirePurchaseProduct->product_group_id = $request->product_group_id;
    //     $hirePurchaseProduct->product_category_id = $request->product_category_id;
    //     $hirePurchaseProduct->product_brand_id = $request->product_brand_id;
    //     $hirePurchaseProduct->product_model_id = $request->product_model_id;
    //     $hirePurchaseProduct->product_size_id = $request->product_size_id;
    //     $hirePurchaseProduct->serial_no = $request->serial_no;
    //     $hirePurchaseProduct->cash_price = $request->cash_price;
    //     $hirePurchaseProduct->hire_price = $request->hire_price;
    //     $hirePurchaseProduct->down_payment = $request->down_payment;
    //     $hirePurchaseProduct->installment_month = $request->installment_month;
    //     $hirePurchaseProduct->monthly_installment = $request->monthly_installment;
    //     $hirePurchaseProduct->save();

    //     // Update showroom credit
    //     $showroom->remaining_credit = $availableCredit - $newDue;
    //     $showroom->save();

    //     // Update installments if the monthly amount or period has changed
    //     if (
    //         $hirePurchaseProduct->monthly_installment != $request->monthly_installment ||
    //         $hirePurchaseProduct->installment_month != $request->installment_month
    //     ) {
    //         // Keep the down payment installment
    //         $firstInstallment = Installment::where('hire_purchase_id', $id)
    //             ->orderBy('id', 'asc')
    //             ->first();

    //         $firstInstallment->amount = $request->down_payment;
    //         $firstInstallment->loan_start_date = date('Y-m-d H:i:00');
    //         $firstInstallment->loan_end_date = date('Y-m-d H:i:00');
    //         $firstInstallment->status = 1;
    //         $firstInstallment->save();
    //         // Delete all other installments
    //         Installment::where('hire_purchase_id', $id)
    //             ->where('id', '!=', $firstInstallment->id)
    //             ->delete();
    //         // Create new installments
    //         for ($i = 1; $i < $request->installment_month; $i++) {
    //             $installmentData = [
    //                 'hire_purchase_id' => $id,
    //                 'amount' => $request->monthly_installment,
    //                 'loan_start_date' => date('Y-m-d H:i:00', strtotime("+$i month")),
    //                 'loan_end_date' => date('Y-m-d H:i:00', strtotime("+" . ($i + 1) . " month")),
    //                 'status' => 0
    //             ];
    //             Installment::create($installmentData);
    //         }
    //     }
    //     // Update transaction
    //     $transaction = Transaction::where('hire_purchase_id', $id)->first();
    //     $transaction->amount = $request->down_payment;
    //     $transaction->transaction_type = "Down Payment";
    //     $transaction->payment_type = 1;
    //     $transaction->created_by = Auth::user()->id;
    //     $transaction->status = 0;
    //     $transaction->save();
    //     // Update ERP log
    //     $erp_log = ErpLog::where('tracking_number', $id)->first();

    //     // Prepare order info
    //     $orderInfo = array_filter([
    //         "eorder_no" => $hirePurchase->order_no,
    //         "entry_date" => now()->toDateTimeString(),
    //         "down_payment" => $request->down_payment,
    //         'instalments_rate' => $request->monthly_installment,
    //         "no_instalments" => (int)$request->installment_month - 1,
    //         "sales_from" => "$showroom->name",
    //         "delivery_from" => "$showroom->name",
    //         "delivery_fee" => 0,
    //         "note" => $request->organization_short_desc,
    //     ]);

    //     $product_model = Product::where('id', $request->product_model_id)->first()->product_model;
    //     // Prepare order details array
    //     $orderDetails = [
    //         [
    //             "item_model"     => "$product_model",
    //             "item_qty"       => 1,
    //             "unit_rate"      => $request->hire_price,
    //             "unit_wise_disc" => 0
    //         ]
    //     ];
    //     // Full data for the API request
    //     $orderJsonDetails = json_encode($orderDetails);
    //     $orderJsonInfo = json_encode($orderInfo);
    //     $erpLogData = [
    //         'order_details' => $orderJsonDetails,
    //         'order_info'    => $orderJsonInfo,
    //         'tracking_number' => $hirePurchase->id,
    //         'sent'           => 0,
    //         // 'response'      => $response
    //     ];
    //     $erp_log->fill($erpLogData)->save();

    //     DB::commit();
    //     return redirect()->back()->with('success', 'Product updated successfully.');
    //     //        } catch (\Throwable $e) {
    //     //            DB::rollback();
    //     //            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
    //     //        }
    // }

    public function Product_update(Request $request, $id)
    {
        date_default_timezone_set('Asia/Dhaka');
        // Find the hire purchase product
        $hirePurchaseProduct = HirePurchaseProduct::where('hire_purchase_id', $id)->firstOrFail();
        $hirePurchase = HirePurchase::findOrFail($id);

        // Store previous data for audit
        $previousData = [
            'product_group_id' => $hirePurchaseProduct->product_group_id,
            'product_category_id' => $hirePurchaseProduct->product_category_id,
            'product_brand_id' => $hirePurchaseProduct->product_brand_id,
            'product_model_id' => $hirePurchaseProduct->product_model_id,
            'product_size_id' => $hirePurchaseProduct->product_size_id,
            'serial_no' => $hirePurchaseProduct->serial_no,
            'cash_price' => $hirePurchaseProduct->cash_price,
            'hire_price' => $hirePurchaseProduct->hire_price,
            'down_payment' => $hirePurchaseProduct->down_payment,
            'installment_month' => $hirePurchaseProduct->installment_month,
            'monthly_installment' => $hirePurchaseProduct->monthly_installment,
        ];

        // Get the original values for comparison
        $originalHirePrice = $hirePurchaseProduct->hire_price;
        $originalDownPayment = $hirePurchaseProduct->down_payment;

        // Get the new values
        $hire_price = $request->hire_price;
        $down_payment = $request->down_payment;

        // Calculate due amounts
        $originalDue = $originalHirePrice - $originalDownPayment;
        $newDue = $hire_price - $down_payment;
        $additionalCreditNeeded = $newDue - $originalDue;

        // Check showroom credit limit
        $showroom = ShowRoom::findOrFail($hirePurchase->showroom_id);
        $availableCredit = $showroom->remaining_credit + $originalDue;

        if ($additionalCreditNeeded > $availableCredit) {
            return redirect()->back()->with('error', 'You have exceeded your credit limitation. Your current available credit is ' . $availableCredit);
        }
        DB::beginTransaction();
        //        try {
        // Update hire purchase product
        $hirePurchaseProduct->product_group_id = $request->product_group_id;
        $hirePurchaseProduct->product_category_id = $request->product_category_id;
        $hirePurchaseProduct->product_brand_id = $request->product_brand_id;
        $hirePurchaseProduct->product_model_id = $request->product_model_id;
        $hirePurchaseProduct->product_size_id = $request->product_size_id;
        $hirePurchaseProduct->serial_no = $request->serial_no;
        $hirePurchaseProduct->cash_price = $request->cash_price;
        $hirePurchaseProduct->hire_price = $request->hire_price;
        $hirePurchaseProduct->down_payment = $request->down_payment;
        $hirePurchaseProduct->installment_month = $request->installment_month;
        $hirePurchaseProduct->monthly_installment = $request->monthly_installment;
        $hirePurchaseProduct->save();

        // Validate and create audit log
        $currentUserId = Auth::user()->id ?? null;
        $userExists = $currentUserId && DB::table('users')->where('id', $currentUserId)->exists();

        if ($userExists) {
            // Create audit log only if user exists
            DB::table('hire_purchase_product_audits')->insert([
                'hire_purchase_product_id' => $hirePurchaseProduct->id,
                'updated_by' => $currentUserId,
                'previous_data' => json_encode($previousData),
                'current_data' => json_encode([
                    'product_group_id' => $request->product_group_id,
                    'product_category_id' => $request->product_category_id,
                    'product_brand_id' => $request->product_brand_id,
                    'product_model_id' => $request->product_model_id,
                    'product_size_id' => $request->product_size_id,
                    'serial_no' => $request->serial_no,
                    'cash_price' => $request->cash_price,
                    'hire_price' => $request->hire_price,
                    'down_payment' => $request->down_payment,
                    'installment_month' => $request->installment_month,
                    'monthly_installment' => $request->monthly_installment,
                ]),
                'changed_fields' => json_encode($this->getChangedFields($previousData, [
                    'product_group_id' => $request->product_group_id,
                    'product_category_id' => $request->product_category_id,
                    'product_brand_id' => $request->product_brand_id,
                    'product_model_id' => $request->product_model_id,
                    'product_size_id' => $request->product_size_id,
                    'serial_no' => $request->serial_no,
                    'cash_price' => $request->cash_price,
                    'hire_price' => $request->hire_price,
                    'down_payment' => $request->down_payment,
                    'installment_month' => $request->installment_month,
                    'monthly_installment' => $request->monthly_installment,
                ])),
                'updated_at' => now(),
                'created_at' => now()
            ]);
        }

        // Update showroom credit
        $showroom->remaining_credit = $availableCredit - $newDue;
        $showroom->save();

        // Update installments if the monthly amount or period has changed
        if (
            $hirePurchaseProduct->monthly_installment != $request->monthly_installment ||
            $hirePurchaseProduct->installment_month != $request->installment_month
        ) {
            // Keep the down payment installment
            $firstInstallment = Installment::where('hire_purchase_id', $id)
                ->orderBy('id', 'asc')
                ->first();

            $firstInstallment->amount = $request->down_payment;
            $firstInstallment->loan_start_date = date('Y-m-d H:i:00');
            $firstInstallment->loan_end_date = date('Y-m-d H:i:00');
            $firstInstallment->status = 1;
            $firstInstallment->save();
            // Delete all other installments
            Installment::where('hire_purchase_id', $id)
                ->where('id', '!=', $firstInstallment->id)
                ->delete();
            // Create new installments
            for ($i = 1; $i < $request->installment_month; $i++) {
                $installmentData = [
                    'hire_purchase_id' => $id,
                    'amount' => $request->monthly_installment,
                    'loan_start_date' => date('Y-m-d H:i:00', strtotime("+$i month")),
                    'loan_end_date' => date('Y-m-d H:i:00', strtotime("+" . ($i + 1) . " month")),
                    'status' => 0
                ];
                Installment::create($installmentData);
            }
        }
        // Update transaction
        $transaction = Transaction::where('hire_purchase_id', $id)->first();
        $transaction->amount = $request->down_payment;
        $transaction->transaction_type = "Down Payment";
        $transaction->payment_type = 1;
        $transaction->created_by = Auth::user()->id;
        $transaction->status = 0;
        $transaction->save();
        // Update ERP log
        $erp_log = ErpLog::where('tracking_number', $id)->first();

        // Prepare order info
        $orderInfo = array_filter([
            "eorder_no" => $hirePurchase->order_no,
            "entry_date" => now()->toDateTimeString(),
            "down_payment" => $request->down_payment,
            'instalments_rate' => $request->monthly_installment,
            "no_instalments" => (int)$request->installment_month - 1,
            "sales_from" => "$showroom->name",
            "delivery_from" => "$showroom->name",
            "note" => $hirePurchase->organization_short_desc,
            'payment_ref' => "Cash"
        ]);

        $product_model = Product::where('id', $request->product_model_id)->first()->product_model;
        // Prepare order details array
        $orderDetails = [
            [
                "item_model"     => "$product_model",
                "item_qty"       => 1,
                "unit_rate"      => $request->hire_price,
                "unit_wise_disc" => 0
            ]
        ];
        // Full data for the API request
        $orderJsonDetails = json_encode($orderDetails);
        $orderJsonInfo = json_encode($orderInfo);
        $erpLogData = [
            'order_details' => $orderJsonDetails,
            'order_info'    => $orderJsonInfo,
            'tracking_number' => $hirePurchase->id,
            'sent'           => 0,
            // 'response'      => $response
        ];
        $erp_log->fill($erpLogData)->save();

        DB::commit();
        return redirect()->back()->with('success', 'Product updated successfully.');
        //        } catch (\Throwable $e) {
        //            DB::rollback();
        //            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        //        }
    }

    // Helper method to get changed fields
    private function getChangedFields($previousData, $currentData)
    {
        $changedFields = [];
        foreach ($previousData as $key => $value) {
            if ($currentData[$key] !== $value) {
                $changedFields[$key] = [
                    'from' => $value,
                    'to' => $currentData[$key]
                ];
            }
        }
        return $changedFields;
    }


    public function PendingSaleView(Request $request)
    {
        $query = HirePurchase::with(['purchase_product', 'purchase_product.product_category', 'purchase_product.brand', 'purchase_product.product', 'show_room', 'show_room_user', 'users'])->whereIn('status', [0]);
        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }
        if ($request->showroom_id) {
            $query->where('showroom_id', $request->showroom_id);
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('show_room', function ($q) use ($stor_type) {
                $q->where('dealar', $stor_type);
            });
        }
        if (Auth::user()->role_id == User::ZONE) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == User::MANAGER) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } elseif (Auth::user()->role_id == User::RETAIL) {

            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }
        $hirepurchase = $query->latest()->get();
        return view('installment.hire_purchase.hire_purchase_pending_ajax_view', compact("hirepurchase"));
    }


    public function SalePendingView(Request $request)
    {
        $query = HirePurchase::with(['purchase_product', 'purchase_product.product_category', 'purchase_product.brand', 'purchase_product.product', 'show_room', 'show_room_user', 'users'])->whereIn('status', [1]);
        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }
        if ($request->showroom_id) {
            $query->where('showroom_id', $request->showroom_id);
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('show_room', function ($q) use ($stor_type) {
                $q->where('dealar', $stor_type);
            });
        }
        if (Auth::user()->role_id == User::ZONE) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == User::MANAGER) {
            $query->where('showroom_id', Auth::user()->showroom_id);
        } elseif (Auth::user()->role_id == User::RETAIL) {

            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }


        $hirepurchase = $query->latest()->get();

        return view('installment.hire_purchase.hire_purchase_pending_ajax_view', compact("hirepurchase"));
    }
    public function ApproveSale($id, ApiService $ApiService)
    {
        date_default_timezone_set('Asia/Dhaka');
        $HirePurchase = HirePurchase::with(['purchase_product'])->findOrFail($id);
        if (Auth::user()->role_id == User::RETAIL) {
            $notification = Notification::where('hire_id', $HirePurchase->id)->first();
            if (empty($notification)) {
                $notification = new Notification();
                $notification->hire_id = $HirePurchase->id;
                $notification->showroom_id = $HirePurchase->showroom_id;
                $notification->retail = 0;
                $notification->manager = 1;
                $notification->zone = 0;
                $notification->admin = 0;
                $notification->save();
            }
            $notification->manager = 1;
            $notification->save();

            $now = Carbon::now();

            $Installment = Installment::where('hire_purchase_id', $id)->get();
            foreach ($Installment as $key => $instal) {
                // $instal->loan_start_date = date('Y-m-d H:i:00', strtotime("+$key month"));
                $instal->loan_start_date = $now->copy()->addMonthsNoOverflow($key)->format('Y-m-d H:i:s');
                $instal->save();
            }
            $HirePurchase->approved_by = Auth::user()->id;
            $HirePurchase->approval_date = date('Y-m-d H:i:00');
            $HirePurchase->status = 3;
            $Transaction = Transaction::where('hire_purchase_id', $id)->first();
            $Transaction->status = 1;
            $Transaction->save();
            $remaining_amount = $HirePurchase->purchase_product->hire_price - $HirePurchase->purchase_product->down_payment;
            $ShowRoom = ShowRoom::where('id', $HirePurchase->showroom_id)->first();
            $ShowRoom->remaining_credit = $ShowRoom->remaining_credit - $remaining_amount;
            $ShowRoom->save();

            $erp_log = ErpLog::where('tracking_number', $id)->first();

            if (!empty($erp_log)) {
                $requestData = [
                    "update_flag" => 0,
                    "cancel_flag" => 0,
                    "cus_info" => json_decode($erp_log->cus_info),
                    "order_info" => json_decode($erp_log->order_info),
                    "order_details" => json_decode($erp_log->order_details)
                ];

                $response =    $ApiService->SendToErp($requestData);
                Log::info('ERP Response: ', ['response' => $response]);
                if ($response['error'] == 1) {
                    $erp_log->sent = 0;
                } else {
                    $erp_log->sent = 1;
                }
                $erp_log->response = $response;
                $erp_log->save();
            }
        } elseif (Auth::user()->role_id == User::MANAGER) {
            $now = Carbon::now();
            $Installment = Installment::where('hire_purchase_id', $id)->get();
            foreach ($Installment as $key => $instal) {
                // $instal->loan_start_date = date('Y-m-d H:i:00', strtotime("+$key month"));
                $instal->loan_start_date = $now->copy()->addMonthsNoOverflow($key)->format('Y-m-d H:i:s');
                $instal->save();
            }
            $HirePurchase->sale_by = Auth::user()->id;
            $HirePurchase->approval_date = date('Y-m-d H:i:00');
            $HirePurchase->status = 3;
            $Transaction = Transaction::where('hire_purchase_id', $id)->first();
            $Transaction->status = 1;
            $Transaction->save();
            $remaining_amount = $HirePurchase->purchase_product->hire_price - $HirePurchase->purchase_product->down_payment;
            $ShowRoom = ShowRoom::where('id', $HirePurchase->showroom_id)->first();
            $ShowRoom->remaining_credit = $ShowRoom->remaining_credit - $remaining_amount;
            $ShowRoom->save();

            $erp_log = ErpLog::where('tracking_number', $id)->first();

            if (!empty($erp_log)) {
                $requestData = [
                    "update_flag" => 0,
                    "cancel_flag" => 0,
                    "cus_info" => json_decode($erp_log->cus_info),
                    "order_info" => json_decode($erp_log->order_info),
                    "order_details" => json_decode($erp_log->order_details)
                ];

                $response =    $ApiService->SendToErp($requestData);
                if ($response['error'] == 1) {
                    $erp_log->sent = 0;
                } else {
                    $erp_log->sent = 1;
                }
                $erp_log->response = $response;
                $erp_log->save();
            }
        }
        $HirePurchase->save();
        return redirect()->back()->with('success', 'Approve Successfully ');
    }

    public function ProductDetails($id)
    {
        $title = "Product Details";
        $description = "Some description for the page";
        $product_details = HirePurchase::with(['purchase_product', 'purchase_product.product_category', 'purchase_product.brand', 'purchase_product.product', 'show_room', 'show_room_user', 'transaction', 'installment', 'erplog'])->findOrFail($id);

        $total_installment_paid = Installment::where('hire_purchase_id', $id)
            ->where('status', 1)
            ->sum('amount');

        $paid_fine_amount = Installment::where('hire_purchase_id', $id)
            ->where('status', 1)
            ->sum('fine_amount');

        $total_loan_paid_amount = $total_installment_paid + $paid_fine_amount;


        $hire_price = $product_details->purchase_product->hire_price ?? 0;

        $totalFine = $this->calculateLateFine($id);

        $out_standing_amount = ($hire_price - $total_installment_paid) + $totalFine;
        // dd($out_standing_amount);

        $installments = Transaction::with(['hire_purchase:id,name,pr_phone', 'users', 'hire_purchase.purchase_product.product'])->where('hire_purchase_id', $id)->get();
        $installment_date = Installment::where('hire_purchase_id', $id)->orderBy('id', 'DESC')->first();


        return view('installment.hire_purchase.product_details', compact("title", "description", "product_details", 'installments', 'installment_date', 'out_standing_amount', 'total_installment_paid', 'totalFine', 'total_loan_paid_amount'));
    }

    public function AllPurchase()
    {
        $title = "Hire Purchase";
        $description = "Some description for the page";
        if (Auth::user()->role_id == User::RETAIL) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $zones = Zone::selectRaw('id, name')->whereIn('id', $permission)->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->whereIn('zone_id', $permission)->where('status', 1)->get();
        } elseif (Auth::user()->role_id == User::ZONE) {

            $showrooms = ShowRoom::selectRaw('id, name')->where('zone_id', Auth::user()->zone_id)->where('status', 1)->get();
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
        } else {
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        }
        return view('installment.hire_purchase.index', compact("title", "description", "zones", "showrooms"));
    }

    public function AllPurchaseAction(Request $request)
    {
        $query = HirePurchase::with([
            'purchase_product.product_category',
            'purchase_product.brand',
            'purchase_product.product',
            'show_room',
            'show_room_user',
            'users'
        ])->where('status', 3);

        // Filter for overdue installments
        if ($request->over_dues) {
            $query->whereHas('installment', function ($q) {
                $q->where('loan_end_date', '<', now())->where('status', 0);
            });
        } elseif ($request->order_no) {
            // If order number is provided, skip date filtering and focus on order search
            $query->where('order_no', 'like', '%' . $request->order_no . '%');
        } elseif ($request->from_date && $request->to_date) {
            // Date filters - only apply if no order number search
            $from_date = Carbon::parse($request->from_date)->startOfDay();
            $to_date = Carbon::parse($request->to_date)->endOfDay();
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        // Filter by zone
        $zone_ids = [];
        if ($request->zone_id) {
            $zone_ids[] = $request->zone_id;
        }
        if (Auth::user()->role_id == User::ZONE) {
            $zone_ids[] = Auth::user()->zone_id;
        }
        if (Auth::user()->role_id == User::RETAIL) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $zone_ids = array_merge($zone_ids, $permission);
        }
        if (!empty($zone_ids)) {
            $query->whereHas('show_room', function ($q) use ($zone_ids) {
                $q->whereIn('zone_id', $zone_ids);
            });
        }
        // Filter by showroom
        if ($request->showroom_id) {
            $query->where('showroom_id', $request->showroom_id);
        }

        // Filter by store type
        if ($request->store_type) {
            $query->whereHas('show_room', function ($q) use ($request) {
                $q->where('dealar', $request->store_type);
            });
        }

        // Final result with pagination
        $hirepurchase = $query->latest()->paginate(20);
        return view('installment.hire_purchase.hire_purchase_ajax_view', compact("hirepurchase"));
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
    public function store(Request $request, ApiService $ApiService)
    {
        // dd($request->all());
        $request->validate([
            'nid'             => 'required|digits_between:10,20',
            'guarater_nid.*'  => 'required|digits_between:10,20',
        ], [
            'nid.required'              => 'National ID is required.',
            'nid.digits_between'        => 'National ID must be at least 10 digits.',
            'guarater_nid.*.required'   => 'Guarantor NID is required.',
            'guarater_nid.*.digits_between' => 'Guarantor NID must be at least 10 digits.',
        ]);

        date_default_timezone_set('Asia/Dhaka');
        // calculate CreditScore With HirePrice
        $hire_price = $request->hire_price;
        $down_payment = $request->down_payment;
        $showroom = ShowRoom::findOrFail(auth()->user()->showroom_id);
        $delivery_showroom = ShowRoom::where('id', $request->delivery_showroom_id)->first();
        $showroom_credit = $showroom->remaining_credit;
        $due = $hire_price - $down_payment;

        $remaining_credit = $showroom_credit - $due;
        if ($due > $showroom_credit) {
            return redirect()->back()->with('error', 'You have exceeded your credit limitation. Your current credit is ' . $showroom_credit);
        }
        DB::beginTransaction();
        try {
            $cus = new Customer;
            $cus_info = [];
            // Customer check
            $check = Customer::where('nid', $request->nid)->get();
            if (count($check) <= 0) {
                $cus_info = $request->only(['age', 'pa_house_no', 'pa_road_no', 'name', 'gender', 'nid']);
                if ($request->same_p_addrs) {
                    $cus_info['district_id'] = $request->pr_district_id;
                    $cus_info['upazila_id'] = $request->pr_upazila_id;
                    $cus_info['pa_house_no'] = $request->pr_house_no;
                    $cus_info['pa_road_no'] = $request->pr_road_no;
                } else {
                    $cus_info['district_id'] = $request->pa_district_id;
                    $cus_info['upazila_id'] = $request->pa_upazila_id;
                }
                $cus_info['created_by'] = Auth::user()->id;
                $cus_info['number'] = $request->pr_phone;

                $cus->fill($cus_info)->save();
                $customer_id = $cus->id;
            } else {
                $customer_id = $check[0]->id;
            }
            //sales info
            $personal_info = $request->only(['showroom_user_id', 'name', 'fathers_name', 'mothers_name', 'spouse_name', 'nid', 'nid_image', 'age', 'marital_status', 'pr_house_no', 'pr_road_no', 'pr_district_id', 'pr_upazila_id', 'pr_phone', 'pr_residence_status', 'pr_duration_staying', 'same_p_addrs', 'pa_house_no', 'pa_road_no', 'pa_district_id', 'pa_upazila_id', 'pa_phone', 'profession_id', 'designation', 'duration_current_profe', 'organization_name', 'organization_short_desc', 'org_house_no', 'org_road_no', 'org_district_id', 'org_upazila_id', 'org_phone', 'month_income', 'number_of_children', 'other_family_member', 'product_name', 'sell_price', 'previously_purchased', 'pre_b_product_id', 'pre_purchase_date', 'pp_showroom_id', 'shipping_address', 'distance_from_showroom', 'facebook_url', 'whatsapp_number', 'email', 'invoice_no', 'type_product', 'checkque_number', 'branch_name', 'bank_account_number', 'bank_id']);
            $names = $request->input('mem_name');
            $relations = $request->input('mem_relation');
            $ages = $request->input('mem_age');

            if ($request->same_p_addrs) {
                $personal_info['pa_house_no'] = $request->pr_house_no;
                $personal_info['pa_road_no'] = $request->pr_road_no;
                $personal_info['pa_district_id'] = $request->pr_district_id;
                $personal_info['pa_upazila_id'] = $request->pr_upazila_id;
                $personal_info['pa_phone'] = $request->pr_phone;
            }

            $personal_info['customer_id'] = $customer_id;
            $last = HirePurchase::orderBy('id', 'DESC')->first();
            if (empty($last)) {
                $next_id = 1;
            } else {
                $next_id = $last->id + 1;
            }
            $event_code = 'BNPLR00' . $next_id;

            $personal_info['order_no'] = $event_code;

            $data = [];
            for ($i = 0; $i < count($names); $i++) {
                $data[] = [
                    'name' => $names[$i],
                    'relation' => $relations[$i],
                    'age' => $ages[$i]
                ];
            }
            // Convert to JSON
            $jsonData = json_encode($data);
            $personal_info['name_age_family_member'] = $jsonData;
            $personal_info['credit_id'] = Session::get('credit_id');
            $personal_info['created_by'] = Auth::user()->id;
            $showroom_user = Session::get('showroom_user_id');
            $personal_info['showroom_user_id'] = $showroom_user;
            $personal_info['delivery_showroom_id'] = $request->delivery_showroom_id;
            $personal_info['showroom_id'] = ShowRoomUser::where('id', $showroom_user)->first()->showroom_id;

            if ($request->hasFile('nid_image')) {
                $request->validate([
                    'nid_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);
                $image = $request->file('nid_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('nid_image'), $imageName);
                $imagePath = 'nid_image/' . $imageName;
                $personal_info['nid_image'] = $imagePath;
            }
            //guarantor info
            $HirePurchase = new HirePurchase;
            $HirePurchase->fill($personal_info)->save();
            //Erp Service
            // $erp_order = $ApiService->OrderCreate($request->all(), $showroom, $HirePurchase->order_no, $HirePurchase->id, $delivery_showroom);
            //guarantor info
            $GuaranterInfo = new GuaranterInfo;
            foreach ($request->guarater_name as $key => $name) {
                $gurantor_info['hire_purchase_id'] = $HirePurchase->id;
                $gurantor_info['guarater_name'] = $request->guarater_name[$key];
                $gurantor_info['guarater_relation'] = $request->guarater_relation[$key];
                $gurantor_info['guarater_relation_name'] = $request->guarater_relation_name[$key];
                $gurantor_info['guarater_address_present'] = $request->guarater_address_present[$key];
                $gurantor_info['guarater_nid'] = $request->guarater_nid[$key];
                $gurantor_info['guarater_phone'] = $request->guarater_phone[$key];

                if ($request->hasFile('guarater_nid_image') && isset($request->file('guarater_nid_image')[$key])) {
                    $image = $request->file('guarater_nid_image')[$key];
                    $imageName = time() . $key . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('guarater_nid_image'), $imageName);
                    $imagePath = 'guarater_nid_image/' . $imageName;
                    $gurantor_info['guarater_nid_image'] = $imagePath;
                }
                GuaranterInfo::create($gurantor_info);
            }

            //hire purchase product

            $hirePurchase_productdata = $request->only(['product_group_id', 'product_category_id', 'product_model_id', 'product_brand_id', 'invoice_no', 'cash_price', 'hire_price', 'down_payment', 'installment_month', 'monthly_installment', 'product_size_id', 'serial_no']);
            $hirePurchase_productdata['hire_purchase_id'] = $HirePurchase->id;
            $hirePurchase_productdata['credit_id'] = Session::get('credit_id');
            $hirePurchase_productdata['total_paid'] = $request->down_payment;


            $HirePurchaseProduct = new HirePurchaseProduct;
            $HirePurchaseProduct->fill($hirePurchase_productdata)->save();

            // transaction and installment

            $Installment = new Installment;

            $installmentData['hire_purchase_id'] = $HirePurchase->id;
            $installmentData['amount'] = $request->down_payment;
            $installmentData['loan_start_date'] = date('Y-m-d H:i:00');
            $installmentData['loan_end_date'] = date('Y-m-d H:i:00');
            $installmentData['status'] = 1;
            $Installment->fill($installmentData)->save();

            $now = Carbon::now();

            for ($i = 1; $i < $request->installment_month; $i++) {
                $installmentNextData['hire_purchase_id'] = $HirePurchase->id;
                $installmentNextData['amount'] = $request->monthly_installment;
                // $installmentNextData['loan_start_date'] = date('Y-m-d H:i:00', strtotime("+$i month"));
                // $installmentNextData['loan_end_date'] = date('Y-m-d H:i:00', strtotime("+" . ($i + 1) . " month"));
                $installmentNextData['loan_start_date'] = $now->copy()->addMonthsNoOverflow($i)->format('Y-m-d H:i:s');
                $installmentNextData['loan_end_date'] = $now->copy()->addMonthsNoOverflow($i + 1)->format('Y-m-d H:i:s');
                Installment::create($installmentNextData);
            }

            $transaction = new Transaction;

            $transactionData['hire_purchase_id'] = $HirePurchase->id;
            $transactionData['transaction_type'] = "Down Payment";
            $transactionData['amount'] = $request->down_payment;
            $transactionData['payment_type'] = 1;
            $transactionData['created_by'] = Auth::user()->id;
            $transactionData['status'] = 0;

            $transaction->fill($transactionData)->save();

            // if ($request->down_payment > 0) {
            //     // Calculate down payment incentive (0.50% if down payment >= 40% of hire price)
            //     $down_payment_percentage = ($request->down_payment / $request->hire_price) * 100;

            //     if ($down_payment_percentage >= 40) {
            //         $down_payment_incentive_rate = 0.50; // 0.50%
            //         $down_payment_incentive_amount = ($request->down_payment * $down_payment_incentive_rate) / 100;

            //         Incentive::create([
            //             'hire_purchase_id' => $HirePurchase->id,
            //             'showroom_user_id' => $showroom_user,
            //             'type' => 'down_payment',
            //             'amount' => $request->down_payment,
            //             'incentive_rate' => $down_payment_incentive_rate,
            //             'incentive_amount' => $down_payment_incentive_amount,
            //             'status' => 'pending'
            //         ]);
            //     }
            // }

            if ($request->down_payment > 0) {
                // Get dynamic values from configuration
                $down_payment_threshold = GeneralIncentiveConfig::getDownPaymentThreshold();
                $down_payment_incentive_rate = GeneralIncentiveConfig::getDownPaymentIncentiveRate();

                // Calculate down payment percentage
                $down_payment_percentage = ($request->down_payment / $request->hire_price) * 100;

                if ($down_payment_percentage >= $down_payment_threshold) {
                    $down_payment_incentive_amount = ($request->down_payment * $down_payment_incentive_rate) / 100;

                    Incentive::create([
                        'hire_purchase_id' => $HirePurchase->id,
                        'showroom_user_id' => $showroom_user,
                        'type' => 'down_payment',
                        'amount' => $request->down_payment,
                        'incentive_rate' => $down_payment_incentive_rate,
                        'incentive_amount' => $down_payment_incentive_amount,
                        'status' => 'pending'
                    ]);
                }
            }

            $product_category_id = $request->product_category_id;
            $product_model_id = $request->product_model_id;

            // Check for Sure Shot Incentive (Model first, then Category - as per your requirement)
            $model_incentive_config = IncentiveConfiguration::where('type', 'model')
                ->where('reference_id', $product_model_id)
                ->where('is_active', true)
                ->first();

            if ($model_incentive_config) {
                // Model-wise incentive applies (Tk 1000 example)
                Incentive::create([
                    'hire_purchase_id' => $HirePurchase->id,
                    'showroom_user_id' => $showroom_user,
                    'type' => 'sure_shot',
                    'sure_shot_type' => 'model',
                    'product_model_id' => $product_model_id,
                    'product_model_name' => $model_incentive_config->name,
                    'amount' => 0, // Or the model amount
                    'incentive_rate' => 0, // Fixed amount, no rate
                    'incentive_amount' => $model_incentive_config->incentive_amount, // Tk 1000
                    'status' => 'pending'
                ]);
            } else {
                // Check category-wise incentive
                $category_incentive_config = IncentiveConfiguration::where('type', 'category')
                    ->where('reference_id', $product_category_id)
                    ->where('is_active', true)
                    ->first();

                if ($category_incentive_config) {
                    // Category-wise incentive applies (Tk 500 example)
                    Incentive::create([
                        'hire_purchase_id' => $HirePurchase->id,
                        'showroom_user_id' => $showroom_user,
                        'type' => 'sure_shot',
                        'sure_shot_type' => 'category',
                        'category_id' => $product_category_id,
                        'product_category_name' => $category_incentive_config->name,
                        'amount' => 0, // Or the category amount
                        'incentive_rate' => 0, // Fixed amount, no rate
                        'incentive_amount' => $category_incentive_config->incentive_amount, // Tk 500
                        'status' => 'pending'
                    ]);
                }
            }

            $showroom->remaining_credit = $remaining_credit;
            $productName = Product::where('id', $request->product_group_id)->first();
            $notification = new Notification();
            $notification->hire_id = $HirePurchase->id;
            $notification->showroom_id = $HirePurchase->showroom_id;
            $notification->product_name = $productName->group_name ?? "";
            $notification->amount = $request->hire_price;
            $notification->retail = 1;
            $notification->manager = 0;
            $notification->zone = 0;
            $notification->admin = 0;
            $notification->save();
            session()->put('hire_price', $request->hire_price);

            DB::commit();
            return redirect('guarantor/' . $HirePurchase->id)->with('success', 'Success!');
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
            return redirect()->back()->with('error', 'Something want wrong ! Please Try Again');
        }
    }


    public function InstallmentList($id)
    {
        $hirepurchase = HirePurchase::findOrfail($id);
        $total_installment_amount = $hirepurchase->installment->where('status', 1)->sum('amount');
        $advance_amount = $hirepurchase->purchase_product->advance_pay;
        $hire_price = $hirepurchase->purchase_product->hire_price;
        $installments = Installment::where('hire_purchase_id', $id)->get();

        foreach ($installments as $installment) {
            // $installment->calculated_late_fee = $this->calculateInstallmentLateFine($installment);
            if ($installment->status == 1) {
                $installment->calculated_late_fee = $installment->fine_amount ?? 0;
            } else {
                $installment->calculated_late_fee = $this->calculateInstallmentLateFine($installment);
            }
        }

        $late_fee = $this->calculateLateFine($id);

        $due = ($hire_price - $total_installment_amount) + $late_fee;



        return view('installment_list', compact("hirepurchase", 'installments', 'total_installment_amount', 'advance_amount', 'due', 'late_fee'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hirePurchase = HirePurchase::with(['purchase_product', 'purchase_product.product_category', 'purchase_product.brand', 'purchase_product.product', 'show_room', 'show_room_user', 'districtpr', 'upazilapr', 'districtpa', 'upazilapa', 'pre_purchase_product', 'ppshow_room', 'customer_profession'])->findOrFail($id);


        $guarantor = GuaranterInfo::where('hire_purchase_id', $id)->get();
        return view('hirepurchase', compact("hirePurchase", "guarantor"));
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function Product_edit($id)
    {

        $title = "Product Edit";
        $description = "Description";
        $query = HirePurchase::with([
            'purchase_product'
        ])->find($id);


        $product_type = ProductType::latest()->get();
        $brands = Brand::latest()->get();

        $products = Product::latest()->get();

        $interestrate = InterestRate::latest()->get();
        $down_payment_parcentage = DownPaymentSetting::latest()->get();
        $showroom_credit = ShowRoom::findOrFail($query->showroom_id);

        if (!$query) {
            return redirect()->back()->with('error', 'Hirepurchase Not Found');
        }

        $hirepurchase_product = $query->purchase_product;


        return view('installment.hire_purchase.product_edit', compact(
            'title',
            'description',
            'hirepurchase_product',
            'product_type',
            'brands',
            'products',
            'interestrate',
            'down_payment_parcentage',
            'showroom_credit',
            'query'
        ));
    }
    public function HirepurchaseEdit($id)
    {

        $title = "Title";
        $description = "Description";
        $all_district = District::get();
        $all_upazilas = Upazila::get();
        $all_customer_profession = CustomerProfession::get();
        $all_banks = Bank::get();

        $query = HirePurchase::with([
            'customer',
            'customer_profession',
            'show_room',
            'show_room_user',
            'guaranter_info',
            'purchase_product',
            'districtpr',
            'districtpa',
            'districtorg',
            'upazilapr',
            'upazilapa',
            'upazilaorg',
            'installment',
            'bank'
        ])->find($id);

        if (!$query) {
            return redirect()->back()->with('error', 'Hirepurchase Not Found');
        }

        $customer = $query->customer;
        $customer_profession = $query->customer_profession;
        $showroom = $query->show_room;
        $showroom_user = $query->show_room_user;
        $guarenter_info = $query->guaranter_info;
        $hirepurchase_product = $query->purchase_product;
        $installments = $query->installment;
        $pr_district = $query->districtpr;
        $pa_district = $query->districtpa;
        $pr_upazilapr = $query->upazilapr;
        $pa_upazilapa = $query->upazilapa;
        $district_org = $query->districtorg;
        $upazila_org = $query->upazilaorg;
        $bank = $query->bank;
        $hirepurchase = $query;


        $view = compact(
            'title',
            'description',
            'customer',
            'customer_profession',
            'showroom',
            'showroom_user',
            'guarenter_info',
            'hirepurchase_product',
            'installments',
            'pr_district',
            'pa_district',
            'district_org',
            'pr_upazilapr',
            'pa_upazilapa',
            'upazila_org',
            'hirepurchase',
            'bank',
            'all_district',
            'all_upazilas',
            'all_customer_profession',
            'all_banks',
        );

        return view('installment.hire_purchase.application_edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function HirepurchaseUpdate(Request $request, HirePurchase $hirePurchase, ApiService $ApiService)
    {
        $h_id = $request->hirepurchase_id;
        $customer_data = $request->only([
            'name',
            'email',
            'age',
            'nid',
            'pa_house_no',
            'pa_road_no',
        ]);

        $profession = CustomerProfession::find($request->profession_id);
        if ($profession) {
            $customer_data['district_id'] = $request->pa_district_id;
            $customer_data['upazila_id'] = $request->pa_upazila_id;
            $customer_data['number'] = $request->pa_phone;
            $customer_data['profession'] = $profession->name;

            $hirepurchase_customer = HirePurchase::with('customer')->find($h_id);
            if ($hirepurchase_customer->customer) {
                $hirepurchase_customer->customer->update($customer_data);
            } else {
                throw new Exception("Customer not found for the given HirePurchase ID");
            }
        } else {
            return redirect()->with('error', "Customer not found");
        }




        foreach ($request->gaurenter_ids as $key => $id) {
            $guarantor = GuaranterInfo::where('id', $id)->first();
            if ($guarantor) {
                $guarantor_info = [
                    'hire_purchase_id' => $h_id,
                    'guarater_name' => $request->guarater_name[$key],
                    'guarater_relation' => $request->guarater_relation[$key],
                    'guarater_relation_name' => $request->guarater_relation_name[$key],
                    'guarater_address_present' => $request->guarater_address_present[$key],
                    'guarater_nid' => $request->guarater_nid[$key],
                    'guarater_phone' => $request->guarater_phone[$key],
                ];

                if ($request->hasFile('guarantor_file') && isset($request->file('guarantor_file')[$key])) {
                    $image = $request->file('guarantor_file')[$key];
                    $imageName = time() . $key . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('guarantor_nid_image'), $imageName);
                    $imagePath = 'guarantor_nid_image/' . $imageName;
                    $guarantor_info['guarater_nid_image'] = $imagePath;
                }
                $guarantor->fill($guarantor_info);
                $guarantor->save();
            }
        }

        $hirepurchase = $request->except([
            'gaurenter_ids',
            'guarater_name',
            'guarater_relation',
            'guarater_relation_name',
            'guarater_address_present',
            'guarater_nid',
            'guarater_phone',
            'mem_name',
            'mem_relation',
            'mem_age'
        ]);

        $members = [];
        foreach ($request->mem_name as $key => $member) {
            $members[] = [
                'name' => $request->mem_name[$key],
                'relation' => $request->mem_relation[$key],
                'age' => $request->mem_age[$key]
            ];
        }
        $imagePath = "";
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('guarantor_nid_image'), $imageName);
            $imagePath = 'guarantor_nid_image/' . $imageName;
        }

        $hirepurchase['nid_image'] = $imagePath;
        $hirepurchase['name_age_family_member'] = json_encode($members);

        $hirepurchaseInstance = HirePurchase::find($request->hirepurchase_id);
        if ($hirepurchaseInstance) {
            $hirepurchaseInstance->update($hirepurchase);


            return redirect('guarantor/' . $hirepurchaseInstance->id)->with('success', 'Success!');
        } else {
            return redirect()->back()->with('error', "Hirepurchase Not Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HirePurchase $hirePurchase)
    {
        //
    }

    /**
     * Reject a hire purchase sale
     */
    public function RejectSale(Request $request, $id)
    {
        // Validate the rejection note
        $request->validate([
            'rejection_note' => 'required|string|max:1000'
        ]);

        try {
            date_default_timezone_set('Asia/Dhaka');

            $hirePurchase = HirePurchase::findOrFail($id);

            // Update hire purchase with rejection details
            $hirePurchase->status = 2; // 2 means Rejected (Cancelled) status
            $hirePurchase->rejection_note = $request->rejection_note;
            $hirePurchase->rejected_by = Auth::user()->id;
            $hirePurchase->rejected_at = now();
            $hirePurchase->save();

            // Update transaction status if exists
            $transaction = Transaction::where('hire_purchase_id', $id)->first();
            if ($transaction) {
                $transaction->status = 0; // Set to inactive/rejected
                $transaction->save();
            }

            // Create notification for the rejection
            $notification = Notification::where('hire_id', $hirePurchase->id)->first();
            if (empty($notification)) {
                $notification = new Notification();
                $notification->hire_id = $hirePurchase->id;
                $notification->showroom_id = $hirePurchase->showroom_id;
                $notification->retail = 1;
                $notification->manager = 0;
                $notification->zone = 0;
                $notification->admin = 0;
                $notification->save();
            } else {
                // Update notification to inform retail about rejection
                $notification->retail = 1;
                $notification->save();
            }

            return redirect()->back()->with('success', 'Sale Rejected Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error rejecting sale: ' . $e->getMessage());
        }
    }

    public function saveDraft(Request $request)
    {
        $draftData = [
            'user_id' => Auth::id(),
            'form_data' => $request->input('form_data'),
            'timestamp' => now(),
        ];

        // Save to database or cache
        Cache::put("hire_purchase_draft_" . Auth::id(), $draftData, now()->addDays(7));

        return response()->json(['status' => 'success']);
    }

    public function loadDraft()
    {
        $draft = Cache::get("hire_purchase_draft_" . Auth::id());
        return response()->json($draft);
    }
}
