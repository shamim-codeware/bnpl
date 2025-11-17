<?php

namespace App\Traits;

use App\Models\Installment;
use Carbon\Carbon;

trait LateFeeCalculationTrait
{
    public function calculateLateFine($hireId)
    {
        $lateFinePerMonth = 500;
        $totalFine = 0;

        $overdueInstallments = Installment::where('hire_purchase_id', $hireId)
            ->where('status', 0)
            ->orderBy('loan_start_date')
            ->get();

        foreach ($overdueInstallments as $installment) {
            $loanStartDate = Carbon::parse($installment->loan_start_date);
            $currentDate = Carbon::now();

            if ($currentDate->greaterThan($loanStartDate)) {
                $monthsOverdue = $loanStartDate->diffInMonths($currentDate);

                if ($monthsOverdue > 1) {
                    $totalFine += ($monthsOverdue - 1) * $lateFinePerMonth;
                }
            }
        }

        return $totalFine;
    }

    private function calculateInstallmentLateFine($installment)
    {
        $lateFinePerMonth = 500;

        // If already paid, no late fee
        if ($installment->status == 1) {
            return 0;
        }

        $loanStartDate = Carbon::parse($installment->loan_start_date);
        $currentDate = Carbon::now();

        if ($currentDate->greaterThan($loanStartDate)) {
            $monthsOverdue = $loanStartDate->diffInMonths($currentDate);

            if ($monthsOverdue > 1) {
                return ($monthsOverdue - 1) * $lateFinePerMonth;
            }
        }

        return 0;
    }
}
