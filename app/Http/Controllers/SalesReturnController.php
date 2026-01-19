<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\SalesReturn;
use App\Models\HirePurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\LateFeeCalculationTrait;

class SalesReturnController extends Controller
{
    use LateFeeCalculationTrait;

    // public function returnDetails($order_no)
    // {
    //     $hirepurchase = HirePurchase::with([
    //         'purchase_products',
    //         'purchase_products.brand',
    //         'purchase_products.product',
    //         'show_room',
    //         'customer'
    //     ])->where('order_no', $order_no)->first();

    //     if ($hirepurchase) {
    //         // Manager showroom check (as in your LoanDetails)
    //         if (Auth::user()->role_id == User::MANAGER) {
    //             if ($hirepurchase->showroom_id != Auth::user()->showroom_id) {
    //                 return response()->json([
    //                     'error' => true,
    //                     'message' => 'This BNPL order is not from your CTP. You can only access orders from your own CTP.'
    //                 ]);
    //             }
    //         }

    //         // Total paid installments
    //         $totalPaid = $hirepurchase->installment()->where('status', 1)->sum('amount');

    //         // Render full partial HTML (like your 'details' view)
    //         return view('pages.sales-return.return-form', compact('hirepurchase', 'totalPaid'));
    //     } else {
    //         return response()->json([
    //             'error' => true,
    //             'message' => 'Order not found. Please check the order number and try again.'
    //         ]);
    //     }
    // }

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
    public function submitReturn(Request $request)
    {
        $request->validate([
            'hire_purchase_id' => 'required|exists:hire_purchases,id',
            'return_reason' => 'required|in:cash_purchase_change,technical_issue,upgrade_model,defaulter_return,others'
        ]);

        $hire = HirePurchase::with('installment')->findOrFail($request->hire_purchase_id);

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
                'notes'            => null, // or add if you collect notes later
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
