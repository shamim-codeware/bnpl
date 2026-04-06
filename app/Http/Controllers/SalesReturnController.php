<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\SalesReturn;
use App\Models\HirePurchase;
use App\Service\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\LateFeeCalculationTrait;

class SalesReturnController extends Controller
{
    use LateFeeCalculationTrait;


    public function returnDetails($order_no)
    {
        $hirepurchase = HirePurchase::with([
            'purchase_products',
            'purchase_products.brand',
            'purchase_products.product',
            'purchase_products.product_category',
            'show_room',
            'customer'
        ])->where('order_no', $order_no)->firstOrFail();

        // Manager showroom check
        if (Auth::user()->role_id == User::MANAGER) {
            if ($hirepurchase->showroom_id != Auth::user()->showroom_id) {
                return response()->json(['error' => true, 'message' => 'Not your showroom order']);
            }
        }

        $totalPaidInstallments = $hirepurchase->installment()
            ->where('status', 1)
            ->sum('amount');

        $totalFine = $hirepurchase->installment()
            ->where('status', 1)
            ->sum('fine_amount');

        $totalLatePaymentFine = $this->calculateLateFine($hirepurchase->id);

        $totalPaidOverall = $totalPaidInstallments + $totalFine;

        $outstandingAmount = ($hirepurchase->hire_price - $totalPaidInstallments) + $totalLatePaymentFine;

        $remainingInstallmentCount = $hirepurchase->installment()->where('status', 0)->count();
        $remainingInstallmentAmount = $hirepurchase->installment()->where('status', 0)->sum('amount');


        return view('pages.sales-return.return-form', compact(
            'hirepurchase',
            'totalPaidInstallments',
            'totalFine',
            'totalLatePaymentFine',
            'totalPaidOverall',
            'outstandingAmount',
            'remainingInstallmentCount',
            'remainingInstallmentAmount'
        ));
    }
    public function submitReturn(Request $request, ApiService $ApiService)
    {
        $request->validate([
            'hire_purchase_id' => 'required|exists:hire_purchases,id',
            'action_type' => 'required|in:return,cancel',
            'return_reason' => 'exclude_if:action_type,cancel|required_if:action_type,return|in:cash_purchase_change,technical_issue,upgrade_model,defaulter_return,others',
            'reference_number' => 'exclude_if:action_type,cancel|required_if:action_type,return|string|max:100',
            'cancel_narration' => 'exclude_unless:action_type,cancel|required_if:action_type,cancel|string|max:500',
        ]);

        $hire = HirePurchase::with('installment')->findOrFail($request->hire_purchase_id);

        if ((int) $hire->status === 5) {
            return redirect()->back()->withErrors(['error' => 'This sale is already returned.']);
        }
        if ((int) $hire->status === 4) {
            return redirect()->back()->withErrors(['error' => 'This sale is already cancelled.']);
        }


        if ($request->action_type === 'cancel') {
            $erpLog = $hire->erplog;

            if (!$erpLog) {
                return redirect()->back()->withErrors(['error' => 'ERP log not found for this order.']);
            }

            $requestData = [
                "update_flag" => 0,
                "cancel_flag" => 1,
                "cus_info" => json_decode($erpLog->cus_info, true),
                "order_info" => json_decode($erpLog->order_info, true),
                "order_details" => json_decode($erpLog->order_details, true)
            ];

            $response = $ApiService->SendToErp($requestData);
            Log::info('ERP Cancel Response', ['response' => $response, 'tracking_number' => $hire->id]);

            $erpLog->response = $response;
            $erpLog->sent = (@$response['error'] == 1) ? 0 : 1;

            if (@$response['error'] == 1) {
                $erpLog->save();
                $msg = $response['msg'] ?? $response['message'] ?? 'Erp Order Cancel Failed. Please try again.';
                return redirect()->back()->withErrors(['error' => $msg]);
            }

            DB::beginTransaction();
            try {
                $erpLog->cancel_flag = 1;
                $erpLog->save();

                $hire->status = 4; // Cancelled
                $hire->cancel_narration = $request->cancel_narration;
                $hire->save();

                DB::commit();
                return redirect()->back()->with('success', 'Sales cancel processed successfully.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Sales Cancel Failed: ' . $e->getMessage());
                return back()->withErrors(['error' => 'Failed to cancel sale. Please try again.']);
            }
        }

        // Calculate total amount paid by customer (down payment + installments)
        $totalPaid = $hire->total_paid;

        // Determine financial treatment based on return reason
        $refundAmount = 0;
        $otherIncome = 0;

        switch ($request->return_reason) {

            case 'defaulter_return':
                // Keep all paid amount as "Other Income" (policy: no refund for defaulter)
                $otherIncome = $totalPaid;
                break;

            case 'upgrade_model':
            case 'cash_purchase_change':
            case 'technical_issue':
            case 'others':
                // Full refund to customer
                $refundAmount = $totalPaid;
                break;
        }

        // Start database transaction
        DB::beginTransaction();
        try {
            // 1. Insert into sales_returns table
            SalesReturn::create([
                'hire_purchase_id' => $hire->id,
                'returned_at'      => now()->toDateString(),
                'reason'           => $request->return_reason,
                'return_amount'    => $hire->hire_price, // Full product value
                'refund_amount'    => $refundAmount,
                'other_income'     => $otherIncome,
                'notes'            => $request->reference_number,
            ]);


            // 2. Update hire purchase status to "returned" (e.g., status = 5)
            $hire->update(['status' => 5]); // Use your status code for "Returned"
            DB::commit();

            return redirect()->back()->with('success', 'Sales return processed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Sales Return Failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to process sales return. Please try again.']);
        }
    }
}
