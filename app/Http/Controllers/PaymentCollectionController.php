<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Zone;
use App\Models\ShowRoom;
use App\Models\Incentive;
use App\Models\Installment;
use App\Models\Transaction;
use App\Service\ApiService;
use App\Models\HirePurchase;
use Illuminate\Http\Request;
use App\Models\ZonePermission;
use App\Models\PaymentErpHistory;
use Illuminate\Support\Facades\DB;
use App\Models\HirePurchaseProduct;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\GeneralIncentiveConfig;
use Illuminate\Support\Facades\Log;



class PaymentCollectionController extends Controller
{
    public function calculateAmountBiaAjax(Request $request)
    {
        $monthlyInstallment = $request->input('monthly_installment');
        $numberOfInstallments = $request->input('number_of_instllment');
        $hire_purchase_id     = $request->input('hire_purchase_id');

        $lateFinePerMonth = 500; // Fixed fine amount
        $totalFine = 0;
        // Fetch the selected number of installments
        $selectedInstallments = Installment::where('status', 0)
            ->orderBy('loan_start_date') // Ensure oldest installments are considered first
            ->take($numberOfInstallments)
            ->where('hire_purchase_id', $hire_purchase_id)
            ->get();

        foreach ($selectedInstallments as $installment) {
            $loanStartDate = Carbon::parse($installment->loan_start_date);
            $currentDate = Carbon::now();
            // Only calculate fine if the start date has passed
            if ($currentDate->greaterThan($loanStartDate)) {
                $monthsOverdue = $loanStartDate->diffInMonths($currentDate);

                // Add fine only if overdue by more than 1 month
                if ($monthsOverdue > 1) {
                    $totalFine += ($monthsOverdue - 1) * $lateFinePerMonth;
                }
            }
        }
        // Calculate the total amount (monthly installment + fine)
        $totalAmount = ($monthlyInstallment * $numberOfInstallments) + $totalFine;

        return response()->json([
            'total_amount' => $totalAmount,
            'fine' => $totalFine,
        ]);
    }
    public function calculateAmount(Request $request)
    {
        $monthlyInstallment = (float) $request->input('monthly_installment');
        $numberOfInstallments = (int) $request->input('number_of_instllment');
        $lateFinePerMonth = 500; // Fixed fine amount
        // Fetch total fine directly using sum() to optimize performance
        $totalFine = Installment::where('status', 0)
            ->where('due_date', '<', Carbon::now()->startOfDay())
            ->get()
            ->sum(function ($installment) use ($lateFinePerMonth) {
                return Carbon::parse($installment->due_date)->diffInMonths(Carbon::now()) * $lateFinePerMonth;
            });

        // Calculate total amount
        $totalAmount = ($monthlyInstallment * $numberOfInstallments) + $totalFine;

        return response()->json([
            'monthly_installment' => $monthlyInstallment,
            'number_of_installments' => $numberOfInstallments,
            'fine_per_month' => $lateFinePerMonth,
            'total_fine' => $totalFine,
            'total_amount' => $totalAmount,
        ]);
    }
    public function LoanDetails($id)
    {
        $hirepurchase = HirePurchase::with(['purchase_products', 'purchase_products.brand', 'purchase_products.product', 'show_room'])->where('order_no', $id)->first();

        if ($hirepurchase) {
            // Check if manager is trying to access BNPL from different CTP/showroom
            if (Auth::user()->role_id == User::MANAGER) { // Manager role
                if ($hirepurchase->showroom_id != Auth::user()->showroom_id) {
                    return response()->json([
                        'error' => true,
                        'message' => 'This BNPL order is not from your CTP. You can only access orders from your own CTP.'
                    ]);
                }
            }

            $installment_due_check = Installment::where('hire_purchase_id', $hirepurchase->id)->where('status', 0)->count();
            return view('installment.payment.details', compact("hirepurchase", "installment_due_check"));
        } else {
            return response()->json([
                'error' => true,
                'message' => 'Order not found. Please check the order number and try again.'
            ]);
        }
    }

    public function PaymentCollection(Request $request, ApiService $ApiService)
    {
        // dd($request->all());
        date_default_timezone_set('Asia/Dhaka');
        $data = $request->all();
        $data['fine_amount'] = (float) ($request->fine_amount ?? 0);
        $data['fine_remarks'] = $request->fine_remarks;
        $data['transaction_type'] = "Installment ";
        $data['created_by'] = Auth::user()->id;
        $advance_payment = 0;

        $number_of_installment = (int) $request->number_of_instllment;
        DB::beginTransaction();
        try {
            //            if ($request->number_of_instllment == 0) {
            $amount = (float) $request->amount;
            $monthly_installment = (float) $request->monthly_installment;
            $number_of_installment = floor($amount / $monthly_installment);
            $total_pay_amount = $monthly_installment * $number_of_installment;
            $advance_payment = (float) $request->amount - $total_pay_amount;
            $data['number_of_instllment'] = $number_of_installment;

            Log::info('Payment calculations', [
                'amount' => $amount,
                'monthly_installment' => $monthly_installment,
                'number_of_installment' => $number_of_installment,
                'advance_payment' => $advance_payment
            ]);
            //            }
            // If no Installment records have status 0, update HirePurchase
            $hirepurchase = HirePurchase::find($request->hire_purchase_id);

            if ($hirepurchase->is_paid == 1) {
                return redirect()->back()->with('error', 'Installment already paid');
            }

            $transaction = new Transaction;
            $transaction->fill($data)->save();
            $transaction_id = $transaction->id;

            $hirepurchase->total_paid += (float) $request->amount;
            $hirepurchase->save();

            $HirePurchaseProduct = HirePurchaseProduct::where('hire_purchase_id', $request->hire_purchase_id)->first();
            // $HirePurchaseProduct->total_paid += (float) $request->amount;
            $HirePurchaseProduct->advance_pay += $advance_payment;
            $HirePurchaseProduct->save();
            $Installment = Installment::where('hire_purchase_id', $request->hire_purchase_id)->where('status', 0)->orderby('id', "ASC")->take($number_of_installment)->get();



            foreach ($Installment as $key => $install) {
                $installment_number = Installment::where('hire_purchase_id', $request->hire_purchase_id)->where('status', 1)->count();

                $paymentRef = "Cash-BNPL-Ins-{$installment_number}";


                $response =    $ApiService->CollectionApi($hirepurchase->order_no, $installment_number, $paymentRef);


                if ($response->error == 1) {
                    $sent = 0;
                } else {
                    $sent = 1;
                }
                if ($advance_payment > 0) {
                    $data =  $ApiService->FineApi($hirepurchase->order_no, $advance_payment, $installment_number, $paymentRef);
                    // return $data;
                }
                $data = [
                    'tracking_id' => $hirepurchase->order_no,
                    'ins_no' => $installment_number,
                    'payment_ref' => "Cash",
                    'response' => $response,
                    'erp_status' => $sent,
                    'transaction_id' => $transaction_id,
                    'installment_id' => $install->id,
                ];
                //PaymentErpHistory::create($data);
                $ins = Installment::findOrFail($install->id);
                $ins->status = 1;

                if ($request->fine_amount > 0 && $key == 0) {
                    $ins->fine_amount = $request->fine_amount;
                    $ins->fine_remarks = $request->fine_remarks;
                }

                $ins->save();
            }

            //if fine  then execute this code
            $installmentCount = Installment::where('hire_purchase_id', $request->hire_purchase_id)->where('status', 0)->count();

            $ShowRoom = ShowRoom::where('id', $hirepurchase->showroom_id)->first();
            $ShowRoom->remaining_credit = $ShowRoom->remaining_credit + (float) $request->amount;
            $ShowRoom->save();

            if ($installmentCount == 0) {
                if ($hirepurchase) {
                    $hirepurchase->is_paid = 1;
                    $hirepurchase->save();
                }
            }

            $allPaid = Installment::where('hire_purchase_id', $request->hire_purchase_id)
                ->where('status', 0)
                ->count() === 0;

            $latestDueDate = Installment::where('hire_purchase_id', $request->hire_purchase_id)
                ->max('loan_start_date');

            $now = Carbon::now();
            $withinDeadline = $now->lte(Carbon::parse($latestDueDate));

            // if ($allPaid && $withinDeadline) {
            //     $incentiveRate = 2.5;
            //     $totalCollected = Transaction::where('hire_purchase_id', $request->hire_purchase_id)->sum('amount');
            //     $incentiveAmount = ($totalCollected * $incentiveRate) / 100;

            //     Incentive::create([
            //         'hire_purchase_id' => $request->hire_purchase_id,
            //         'showroom_user_id' => $hirepurchase->showroom_user_id, // à¦…à¦¥à¦¬à¦¾ showroom_user_id from hirepurchase
            //         'type' => 'collection',
            //         'amount' => $totalCollected,
            //         'incentive_rate' => $incentiveRate,
            //         'incentive_amount' => $incentiveAmount,
            //         'status' => 'pending',
            //         'payment_date' => null,
            //     ]);
            // }

            if ($allPaid && $withinDeadline) {

                $incentiveStartDate = Carbon::create(2025, 12, 1);

                Incentive::where('hire_purchase_id', $request->hire_purchase_id)
                    ->whereIn('type', ['down_payment', 'sure_shot'])
                    ->update(['status' => 'approved']);
                if ($hirepurchase->created_at->gte($incentiveStartDate)) {

                    $incentiveRate = GeneralIncentiveConfig::getCollectionIncentiveRate();
                    $totalCollected = Transaction::where('hire_purchase_id', $request->hire_purchase_id)->sum('amount');
                    $incentiveAmount = ($totalCollected * $incentiveRate) / 100;

                    Incentive::create([
                        'hire_purchase_id' => $request->hire_purchase_id,
                        'showroom_user_id' => $hirepurchase->showroom_user_id,
                        'type' => 'collection',
                        'amount' => $totalCollected,
                        'incentive_rate' => $incentiveRate,
                        'incentive_amount' => $incentiveAmount,
                        'status' => 'pending',
                        'payment_date' => null,
                    ]);
                }
            }

            if ($response->error == 1) {
                // $erp_log->sent = 0;
                // echo $response['error'];
            } else {
                //    $erp_log->sent = 1;
            }
            DB::commit();
            return redirect()->back()->with('success', 'Success! Installment');
        } catch (Exception $e) {
            DB::rollback();
            return redirect('')->with('error', $e->getMessage());
        }
    }
    public function TransactionList()
    {
        $title = "Product Details";
        $description = "Some description for the page";
        if (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $zones = Zone::selectRaw('id, name')->whereIn('id', $permission)->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->whereIn('zone_id', $permission)->where('status', 1)->get();
        } elseif (Auth::user()->role_id == 2) {
            $showrooms = ShowRoom::selectRaw('id, name')->where('zone_id', Auth::user()->zone_id)->where('status', 1)->get();
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
        } else {
            $zones = Zone::selectRaw('id, name')->orderBy('id', 'ASC')->where('status', 1)->get();
            $showrooms = ShowRoom::selectRaw('id, name')->where('status', 1)->get();
        }

        return view('installment.payment.history', compact("title", "description", "zones", "showrooms"));
    }

    public function TransactionListShow(Request $request)
    {

        $query = Transaction::with(['hire_purchase:id,order_no,name,pr_phone,showroom_id,status', 'users', 'hire_purchase.purchase_products.product', 'hire_purchase.show_room'])
            ->where('status', 1)->whereHas('hire_purchase', function ($q) {
                $q->where('status', 3);
            });

        if ($request->from_date && $request->to_date) {
            // Date query
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            // Date
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($request->order_no) {
            $query->whereHas('hire_purchase', function ($q) use ($request) {
                $q->where('order_no', 'LIKE', '%' . $request->order_no . '%');
            });
        }

        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }
        if ($request->showroom_id) {
            $showroom_id = $request->showroom_id;
            // Zone
            $query->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id', $showroom_id);
            });
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('hire_purchase.show_room', function ($q) use ($stor_type) {
                $q->where('dealar', $stor_type);
            });
        }


        if (Auth::user()->role_id == 2) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == 3) {
            $showroom_id = Auth::user()->showroom_id;
            $query->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id', $showroom_id);
            });
        } elseif (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('hire_purchase.show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }

        // Get per_page value from request, default to 30
        $perPage = $request->per_page ? (int) $request->per_page : 30;
        $installments = $query->latest()->paginate($perPage);


        return view('installment.payment.payment-history-ajax', compact("installments"));
    }
    public function TransactionListExport(Request $request)
    {
        $query = Transaction::with(['hire_purchase:id,order_no,name,pr_phone,showroom_id,status', 'users', 'hire_purchase.purchase_products.product', 'hire_purchase.show_room'])
            ->where('status', 1)->whereHas('hire_purchase', function ($q) {
                $q->where('status', 3);
            });

        if ($request->from_date && $request->to_date) {
            // Date query
            $from_date = date('Y-m-d 00:00:00', strtotime($request->from_date));
            $to_date = date('Y-m-d 23:59:59', strtotime($request->to_date));
            // Date
            $query->whereBetween('created_at', [$from_date, $to_date]);
        }

        if ($request->order_no) {
            $query->whereHas('hire_purchase', function ($q) use ($request) {
                $q->where('order_no', 'LIKE', '%' . $request->order_no . '%');
            });
        }

        if ($request->zone_id) {
            $zone_id = $request->zone_id;
            // Zone
            $query->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        }
        if ($request->showroom_id) {
            $showroom_id = $request->showroom_id;
            // Zone
            $query->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id', $showroom_id);
            });
        }

        if ($request->store_type) {
            $stor_type = $request->store_type;
            $query->whereHas('hire_purchase.show_room', function ($q) use ($stor_type) {
                $q->where('dealar', $stor_type);
            });
        }

        if (Auth::user()->role_id == 2) {
            $zone_id = Auth::user()->zone_id;
            $query->whereHas('hire_purchase.show_room', function ($q) use ($zone_id) {
                $q->where('zone_id', $zone_id);
            });
        } elseif (Auth::user()->role_id == 3) {
            $showroom_id = Auth::user()->showroom_id;
            $query->whereHas('hire_purchase', function ($q) use ($showroom_id) {
                $q->where('showroom_id', $showroom_id);
            });
        } elseif (Auth::user()->role_id == 6) {
            $permission = ZonePermission::where('user_id', Auth::user()->id)->pluck('zone_id')->toArray();
            $query->whereHas('hire_purchase.show_room', function ($q) use ($permission) {
                $q->whereIn('zone_id', $permission);
            });
        }

        $transactions = $query->latest()->get();
        $filename = 'transaction-list-report-' . \App\Helpers\Helper::formatDateTimeFilename() . '.xlsx';
        return Excel::download(new \App\Exports\TransactionExport($transactions), $filename);
    }
}
